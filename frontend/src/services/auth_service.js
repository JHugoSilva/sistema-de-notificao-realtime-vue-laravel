import { http } from "./http_service";

export function register(data) {
    return http().post('auth/register', data)
}

export function login(data) {
    return http().post('auth/login', data)
}

export function updateProfile(data) {
    return http().put('auth/update-profile', data)
}

export function changePassword(data) {
    return http().put('auth/change-password', data)
}

export function logoOut() {
    return http().delete('auth/logout')
}