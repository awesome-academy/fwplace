import actions from './actions'
import mutations from './mutations'

const state = {
    status: ''
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
}
