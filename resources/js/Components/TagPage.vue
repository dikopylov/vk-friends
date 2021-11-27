<template>
  <div class="container-fluid">
    <div class="container">
      <div class="input-group mb-3">
        <router-link :to="{name: 'tags.create'}">Создать тег</router-link>
      </div>

      <div class="row w-50 mx-auto"
           v-for="tag in tags"
           :key="tag.id">
        <div class="btn btn-primary"
             type="submit">
          {{ tag.value }}
          <button type="button"
                  class="btn btn-default"
                  @click="deleteTag">
            <span class="glyphicon glyphicon-remove"
                  aria-hidden="true"></span>Удалить
          </button>
        </div>
      </div>
    </div>

    <div
      class="row w-50 mx-auto"
      v-for="friend in friends"
      :key="friend.id">
      <friend-list-row :friend="friend"
                       :slots="slots"></friend-list-row>
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
    slots   : {
      type    : Object,
      required: false,
    },
  },
  data () {
    return {
      friends: [],
      tags   : [],
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

          this.$emit('fetch-friends', this.friends);

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
