<?php

namespace App;

enum PermissionEnum : string
{
    case VIEW_POSTS = 'view posts';
    case CREATE_POSTS = 'create posts';
    case EDIT_POSTS = 'edit posts';
    case DELETE_POSTS = 'delete posts';

    case VIEW_USERS = 'view users';
    case CREATE_USERS = 'create users';
    case EDIT_USERS = 'edit users';
    case DELETE_USERS = 'delete users';


}
