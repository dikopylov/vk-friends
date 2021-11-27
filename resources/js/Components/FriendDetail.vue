<template>
    <div>
      <router-link :to="{name: 'friends.index'}"
                   class="nav-item nav-link">
        <div class="text-center"
             style="margin: 20px 0px 20px 0px;">
            <span class="text-secondary">Назад</span>
        </div>
      </router-link>

      <friend-list :endpoint="endpoint"></friend-list>
    </div>
</template>

<script>
import FriendList from './FriendList';

export default {
    components: { FriendList },
    computed: {
        endpoint() {
            return '/api/friends/mutual/' + this.$route.params.id;
        },
    },
};
</script>

<style scoped>

</style>
