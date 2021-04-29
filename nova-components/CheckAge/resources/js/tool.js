Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'check-age',
      path: '/check-age',
      component: require('./components/Tool'),
    },
  ])
})
