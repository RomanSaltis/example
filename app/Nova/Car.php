<?php

namespace App\Nova;

use App\Nova\Filters\CarFilter;
use App\Nova\Filters\PriceFilter;
use App\Nova\Filters\UserCarFilter;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Filters\BrandFilter;

class Car extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Car::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public function  title(){
        return "{$this->brand} {$this->model} Id {$this->id} ";
    }


    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','brand','model',
    ];

    public static function relatableUsers(NovaRequest $request, $query)
    {
        // filter the users that do not have a car relation yet for with a car that is registered to the same
        // company as the company the current car belongs to
        $company = \App\Models\Car::find($request->resourceId)->company;
        return $query->whereDoesntHave('cars', function($q) use ($company) {
            $q->where('company_id', $company->id);
        });
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('brand')->sortable(),
            Text::make('model'),
            Text::make('price')->sortable(),
            BelongsTo::make('company'),
            BelongsToMany::make('user')
            ->fields(function (){
                return [
                    Text::make('start'),
                    Text::make('end'),
                ];
            }),
            Date::make('created at'),
            Date::make('updated at'),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new BrandFilter,
            new PriceFilter,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
