<?php

namespace App\Nova;

use App\Nova\Actions\NotifyEmployees;
use App\Nova\Filters\NewEmployees;
use App\Nova\Metrics\Employees;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Country;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Employee extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Employee::class;

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
        'id', 'name', 'email'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Gravatar::make(),
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('Name', 'name')->rules('required')->rules('required'),
            Number::make('Mobile Number', 'mobile_number')->rules('required'),
            Text::make('Email Address', 'email')->rules('required'),
            Number::make('Salary Range', 'salary')->rules('required'),
            Country::make('Country', 'country')->rules('required'),
            Image::make('Profile Image', 'profile_image')->creationRules('required')->updateRules('nullable')->prunable()->deletable(false)->rounded(),
            Select::make('Gender')->options([
                'Male' => 'Male',
                'Female' => 'Female',
                'Others' => 'Others',
            ])->rules('required'),
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
            (new Employees)->help('This is used to retrieve all the employees registered in the database.'),
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
            new NewEmployees
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
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        // return [
        //     new NotifyEmployees
        // ];
        return [
            (new \App\Nova\Actions\NotifyEmployees)
                ->confirmText('Are you sure you want to activate this user?')
                ->confirmButtonText('Send Announcement')
                ->cancelButtonText("Cancel"),
        ];
    }
}
