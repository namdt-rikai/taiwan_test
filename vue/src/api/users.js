import request from '../utils/request'

export function getListUser() {
    return request({
        url: '/users',
        method: 'get',
    })
}

export function getDetailUser(userName) {
    return request({
        url: `/users/${userName}`,
        method: 'get',
    })
}