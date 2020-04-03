Nova.booting((Vue, router, store) => {
  Vue.component('index-fieldsForNovelUser', require('./components/IndexField'))
  Vue.component('detail-fieldsForNovelUser', require('./components/DetailField'))
  Vue.component('form-fieldsForNovelUser', require('./components/FormField'))
})
