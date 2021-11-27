<template>
  <div>
    <router-link :to="{name: 'friends.detail', params: { id: friend.id },}"
                 class="nav-item nav-link">
      <div class="col-12 mt-3">
        <div class="card">
          <div class="card-horizontal">
            <div class="img-square-wrapper">
              <img :src="friend.avatar"
                   alt="Avatar">
            </div>
            <div class="card-body">
              <h4 class="card-title">{{ friend.name }}</h4>
              <p v-if="hasCountMutual" class="card-text">Общих друзей: {{ friend.count_mutual }}</p>
            </div>
          </div>
        </div>
      </div>
    </router-link>
  </div>
</template>

<script>
export default {
  props: {
    friend: {
      type    : Object,
      required: true,
    },
  },
  data: function () {
    return {
      hasCountMutual: this.friend.hasOwnProperty('count_mutual'),
    };
  },
};
</script>

<style scoped>
.card-horizontal {
  display : flex;
  flex    : 1 1 auto;
}
</style>
