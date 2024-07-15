<?php

namespace App\Services;

use App\DTO\FilterDataUserDTO;
use App\DTO\StoreHistoryDTO;
use App\Helpers\CacheHelper;
use App\Models\User;
use App\Repositories\HistoryRepository\HistoryRepository;
use App\Repositories\UserRepository\UserRepository;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = app(UserRepository::class);
    }

    public function getWithFilters($request): Collection
    {
        $filterParams = new FilterDataUserDTO($request);
        $cacheParams = CacheHelper::getParamsFromFilter($filterParams, 'users');

        return CacheHelper::checkAndPut($cacheParams, function() use ($filterParams){
            return $this->userRepository->getWithFilter($filterParams);
        });
    }

    public function getById($id)
    {
        return $this->userRepository->getById($id);
    }

    public function deletedList($request)
    {
        $filterParams = new FilterDataUserDTO($request);

        return $this->userRepository->getDeletedWithFilter($filterParams);
    }

    public function update($id, $requestData)
    {
        $before_user = $this->userRepository->getById($id);
        $this->userRepository->update($id, $requestData->toArray());
        $after_user = $this->userRepository->getById($id);
        $this->addToHistory($id, $before_user->toJson(), $after_user->toJson());

        return $after_user;
    }

    public function delete(array $ids)
    {
        $before_users = $this->userRepository->getListWhereIds($ids);
        $status = $this->userRepository->delete($ids);
        $after_users = $this->userRepository->getListWhereIds($ids);

        foreach ($before_users as $before_user){
            $this->addToHistory($before_user->id, $before_user->toJson(), $after_users->where('id', $before_user->id)->first()->toJson());
        }

        return $status;
    }

    public function destroy(array $ids)
    {
        return $this->userRepository->destroy($ids);
    }

    public function restore(array $ids)
    {
        return $this->userRepository->restore($ids);
    }

    public function addToHistory($id, string $before_user, string $after_user): void
    {
        $storeHistory = new StoreHistoryDTO();
        $storeHistory->model_id = $id;
        $storeHistory->model_name = User::class;
        $storeHistory->before = $before_user;
        $storeHistory->after = $after_user;
        $storeHistory->action = 'update';
        app(HistoryRepository::class)->create($storeHistory);
    }
}
