<?php

return [

    /**
     * User model path
     */
    'user_model' => \App\Models\User::class,

    /**
     * User column name where to store the avatar profile path
     */
    'user_profile_avatar_column' => 'image_profile_path',

    /**
     * Storage where to store the path
     */
    'storage_path_for_avatar' => storage_path('app/public/' . $this->id . '.png'),

    /**
     * By default, the avatar will be generated if the user is created or updated and the `user_profile_avatar_column` is
     * null, if specify true, only will try the first time when the user is created
     */
    'generate_only_when_user_is_created' => true,

    /**
     * If name and lastname are in separated columns, specify using an array instead of a string:
     * something like this:
     *
     * 'user_column_name' => ['name', 'lastname'],
     *
     */
    'user_column_name' => 'name',

    /**
     * In case that name or name and lastname do not accomplish the required specifications, the first two letters of the
     * email will be use for generate the avatar
     */
    'use_user_email_as_fallback_for_initials' => true,

    /**
     * If array of hex colors is provided will only use them to generate avatars, default is blue: #37c0da
     */
    'background_colors_list' => null

];
