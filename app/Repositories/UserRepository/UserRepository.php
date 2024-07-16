<?php

namespace App\Repositories\UserRepository;

use App\DTO\FilterDataUserDTO;
use App\Models\User;
use App\Repositories\CoreRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends CoreRepository
{
    protected function getModelClass(): string
    {
        return User::class;
    }
    private function setFields($orderBy = 'id', $orderType = 'ASC', $fields = ['id', 'last_name', 'name', 'middle_name', 'phone', 'email']): Builder
    {
        return $this->startConditions()->select($fields)->orderBy($orderBy, $orderType);
    }

    public function getWithFilter(FilterDataUserDTO $filterParams): Collection
    {
        $query = $this->setFields();
        $request = new UserRepositoryQuery($query);

        $request->whenId($filterParams->id)
            ->whenLastName($filterParams->last_name)
            ->whenName($filterParams->name)
            ->whenMiddleName($filterParams->middle_name)
            ->whenPhone($filterParams->phone)
            ->whenEmail($filterParams->email);

        return $query->get();
    }

    public function getListWhereIds($ids): Collection
    {
        $query = $this->setFields()->withTrashed()->whereIn('id', $ids);

        return $query->get();
    }

    public function getById($id)
    {
        $query = $this->setFields()->find($id);

        return $query;
    }

    public function getDeletedWithFilter(FilterDataUserDTO $filterParams): Collection
    {
        $query = $this->setFields()->onlyTrashed();
        $request = new UserRepositoryQuery($query);

        $request->whenId($filterParams->id)
            ->whenLastName($filterParams->last_name)
            ->whenName($filterParams->name)
            ->whenMiddleName($filterParams->middle_name)
            ->whenPhone($filterParams->phone)
            ->whenEmail($filterParams->email);

        return $query->get();
    }

    public function update($id, $requestData)
    {
        $query = $this->setFields()->where('id', $id);

        return $query->update($requestData);
    }

    public function delete(array $ids): int
    {
        $query = $this->startConditions()->destroy($ids);

        return $query;
    }

    public function destroy(array $ids)
    {
        $query = $this->setFields()->withTrashed()->whereIn('id', $ids)->forceDelete();

        return $query;
    }

    public function restore(array $ids)
    {
        $query = $this->setFields()->onlyTrashed()->whereIn('id', $ids)->restore();

        return $query;
    }
}
