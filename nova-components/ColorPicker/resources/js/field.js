Nova.booting((Vue, router, store) => {
  Vue.component('index-color-picker', require('./components/IndexField'))
  Vue.component('detail-color-picker', require('./components/DetailField'))
  Vue.component('form-color-picker', require('./components/FormField'))
})
