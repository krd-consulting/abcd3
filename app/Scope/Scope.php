<?php

namespace App\Scope;

use App\Scope as ScopeTable;
use App\Collection as CollectionTable;
use App\User;

class Scope {
    private $user;

    public function setUser(User $user) {
        $this->user = $user;
    }

    // Entity? - Records
    // - getRecords(user)

    // Entity? - Collections
    // - getCollectionInstances(user, collectionType -- team/group/program/caserecord)
    // - some magic methods:
    //  - getTeams(user)
    //  - getPrograms(user)

    // Forms
    // - getForms(user)

    private static function getScopesLessThanOrEqualTo(ScopeTable $scope) {
        return ScopeTable::where('value' , '<=', $scope->value)->get()->pluck('model_type');
    }

    public static function getCollectionTypes(ScopeTable $scope) {
        $scopes = self::getScopesLessThanOrEqualTo($scope);
        $collectionTypes = [];

        foreach ($scopes as $scopeModel) {
            $scopeObject= new $scopeModel;
            if(!empty($collectionType = $scopeObject->getCollectionType()))
                $collectionTypes[] = $collectionType;
        }

        return $collectionTypes;
    }

    public function getCollectionType() {
        return;
    }

    public function getCollectionTypeInstance() {
        if(empty($collectionType = $this->getCollectionType())) {
            return;
        }

        return new $collectionType->model_type;
    }
    // - getFormParentEntities(user, form)
    public function getFormParentEntities($form) {

    }
    //  - collection -> getFormParentEntities(user)

    // Form Entries
    // - getFormEntries(user, form)
}