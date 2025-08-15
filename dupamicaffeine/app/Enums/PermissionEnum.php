<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case MANAGE_USERS = 'manage_users';
    case MANAGE_ROLES = 'manage_roles';
    case MANAGE_PERMISSIONS = 'manage_permissions';
    case MANAGE_CATEGORIES = 'manage_categories';
    case MANAGE_PRODUCTS = 'manage_products';
    case MANAGE_ORDERS = 'manage_orders';
    case MANAGE_COUPONS = 'manage_coupons';
    case VIEW_ALL_REVIEWS = 'view_all_reviews';
    case MANAGE_MEDIA = 'manage_media';
    case VIEW_PRODUCTS = 'view_products';
    case VIEW_CATEGORIES = 'view_categories';
    case ADD_TO_CART = 'add_to_cart';
    case UPDATE_CART = 'update_cart';
    case REMOVE_FROM_CART = 'remove_from_cart';
    case CHECKOUT = 'checkout';
    case VIEW_OWN_ORDERS = 'view_own_orders';
    case APPLY_COUPON = 'apply_coupon';
    case WRITE_REVIEW = 'write_review';
    case EDIT_OWN_REVIEW = 'edit_own_review';
    case DELETE_OWN_REVIEW = 'delete_own_review';
    case ADD_TO_WISHLIST = 'add_to_wishlist';
    case REMOVE_FROM_WISHLIST = 'remove_from_wishlist';
    case VIEW_OWN_WISHLIST = 'view_own_wishlist';
    case VIEW_OWN_PROFILE = 'view_own_profile';
    case UPDATE_OWN_PROFILE = 'update_own_profile';
}