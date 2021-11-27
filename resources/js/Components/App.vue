<template>
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="collapse navbar-collapse">
        <div class="navbar-nav">
          <router-link to="/friends" class="nav-item nav-link">Друзья</router-link>
          <router-link to="/tags" class="nav-item nav-link">Поиск по тегу</router-link>
        </div>
      </div>
    </nav>
    <br/>
    <router-view></router-view>
  </div>
</template>

<script>

export default {
    computed: {
        endpoint () {
            return '/api/friends/';
        },
    },
    mounted () {
        if (this.$route.name === 'home') {
            this.redirectToFriends();
        }
    },
    methods: {
        redirectToFriends () {
            this.$router.push({ name: 'friends.index', params: { endpoint: this.endpoint } });
        },
    },
};
</script>

<style scoped>

</style>
