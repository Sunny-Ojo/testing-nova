Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'custom-view',
      path: '/custom-view',
      component: require('./components/Tool'),
    },
  ])
})
