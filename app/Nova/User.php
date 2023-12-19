<?php

namespace App\Nova;

use App\Enums\GenderType;
use App\Nova\Actions\EmailVerifiedUser;
use App\Nova\Filters\UserCarFilter;
use App\Nova\Filters\UserHasFilter;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Enum;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
//    public static $title = 'name';
    public function  title(){
        return "{$this->name} Id {$this->id} ";
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email',
    ];

    public static function relatableCars(NovaRequest $request, $query)
    {
        return $query->whereDoesntHave('user');
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

//            Gravatar::make()->maxWidth(50),

            Text::make('Name')
                ->rules('required', 'min:2', 'max:255')
                ->sortable(),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Text::make('email_verified_at'),
            Text::make('password')
                ->creationRules('required', Rules\Password::defaults())
                ->updateRules('nullable', Rules\Password::defaults()),
            Text::make('remember_token'),
            Date::make('created_at'),
            Date::make('updated_at'),
            Text::make('gender')
                ->rules('required', new Enum(GenderType::class)),
            Boolean::make('email_verified'),
            Text::make('activation_code'),



//            Password::make('Password')
//                ->onlyOnForms()
//                ->creationRules('required', Rules\Password::defaults())
//                ->updateRules('nullable', Rules\Password::defaults()),

            BelongsToMany::make('companies')
                ->fields(function (){
                    return [
                        Text::make('salary'),
                        Text::make('job_title_id'),
                        Text::make('holiday'),
                        Text::make('company_office_id'),
                    ];
                }),
            BelongsToMany::make('cars'),
            HasOne::make('adminuser'),
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
            new UserHasFilter,
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
        return [
            (new EmailVerifiedUser)->canSee(function ($request){
                return $request->user()->isSuper;
            })
        ];
    }
}
