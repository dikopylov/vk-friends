<template>
  <div class="container-fluid">

    <div
      class="row w-50 mx-auto"
      v-for="friend in friends"
      :key="friend.id">
      <friend-list-row :friend="friend"></friend-list-row>
    </div>
    <infinite-loading @infinite="fetchFriends">
      <div slot="spinner">Загрузка...</div>
      <div slot="no-more"></div>
      <div slot="no-results">Друзей нет</div>
    </infinite-loading>
  </div>
</template>

<script>
import InfiniteLoading from 'vue-infinite-loading';
import FriendListRow   from './FriendListRow';

export default {
  components: { FriendListRow, InfiniteLoading },
  props     : {
    endpoint: {
      type   : String,
      default: 'api/friends',
    },
  },
  data () {
    return {
      friends: [],
      page   : 1,
    };
  },
  methods: {
    fetchFriends (state) {
      this.axios.get(this.endpoint, {
        params: {
          page: this.page,
        },
      }).then(({ data }) => {
        if (this.page <= data.meta.last_page) {
          this.page += 1;

          this.friends.push(...data.data);

          state.loaded();
        }
        else {
          state.complete();
        }
      });
    },
  },
};
</script>

<style scoped>

</style>
