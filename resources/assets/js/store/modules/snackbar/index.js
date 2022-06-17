import getters from './getters'
import mutations from './mutations'

const state = {
  show: false,
  color: 'error',
  text: 'error',
  subText: '',
  timeout: 6000,
   y: 'bottom',
   x: 'right'
}

export default {
  state,
  getters,
  mutations
}
