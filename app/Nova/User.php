<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use App\Nova\Filters\UserType;
use App\Nova\Metrics\NewUsers;
use Laravel\Nova\Fields\HasOne;
use App\Nova\Filters\UserStatus;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use App\Nova\Filters\DateCreated;
use App\Nova\Metrics\UsersPerDay;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Password;
use App\Nova\Metrics\UsersPerPlan;
use App\Nova\Filters\BirthdayFilter;
use App\Nova\Lenses\MostValuableUsers;
use App\Nova\Metrics\MostValuableUsers as valueableUsers;
use Illuminate\Database\Eloquent\Model;
use Acme\StripeInspector\StripeInspector;
use App\Nova\Actions\EmailAccountProfile;
use Laravel\Nova\Http\Requests\ActionRequest;
use Workdoneright\GroupByTool\GroupByTool;

class User extends Resource
{
    public $withoutActionEvents = true;

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
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email',
    ];
    public static $perPageOptions = [10, 20, 150];


    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable()->hideFromIndex(),

            Gravatar::make()->maxWidth(50),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Boolean::make('Active')->default(true)->hideWhenCreating()->sortable(),
            DateTime::make('Created At', 'created_at')->onlyOnIndex(),
            HasMany::make('Blogs'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),
            StripeInspector::make(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            new NewUsers,
            new UsersPerDay,
            new valueableUsers,

            // new UsersPerPlan

        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new UserType,
            new DateCreated,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [
            new Lenses\MostValuableUsers
        ];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            Actions\EmailAccountProfile::make()->confirmText('Are you sure you want to activate this user?')
                ->confirmButtonText('Send Email')
                ->cancelButtonText("Cancel"),
            Actions\ActivateUsers::make()->confirmText('Are you sure you want to activate this user(s)?')
                ->confirmButtonText('Activate')
                ->cancelButtonText("Don't activate"),
            Actions\SuspendUsers::make()->confirmText('Are you sure you want to suspend this user(s)?')
                ->confirmButtonText('Suspend')
                ->cancelButtonText("Don't Suspend"),

        ];
    }
}
