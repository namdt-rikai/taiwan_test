import { getListUser, getDetailUser } from "../../api/users";

const state = {
    list: {},
    user: {}
};

const actions = {
    async getListUser({ commit }) {
        console.log(commit)
        return new Promise((resolve, reject) => {
            getListUser()
                .then((response) => {
                    commit("setListUser", response.data);
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                });
        });
    },
    async getDetailUser({ commit }, {username}) {
        return new Promise((resolve, reject) => {
            getDetailUser(username)
                .then((response) => {
                    commit("setUser", response.data);
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                });
        });
    },
};

const mutations = {
    setListUser: (state, users) => {
        state.list = users;
    },
    setUser: (state, user) => {
        state.user = user;
    },
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
};
