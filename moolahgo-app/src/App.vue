<template>
  <v-app>
    <v-app-bar
      app
      color="primary"
      dark
    >
      <div class="headline d-flex align-center">
        Sandino Cardinoza
      </div>
      <v-spacer></v-spacer>
    </v-app-bar>

    <v-main>
      <RefCodeCheckerForm/>
    </v-main>
  </v-app>
</template>

<script>
import RefCodeCheckerForm from './components/RefCodeCheckerForm'

export default {
  name: 'App',
  components: {
    RefCodeCheckerForm
  },

  data: () => ({
    //
  }),
};
</script>
