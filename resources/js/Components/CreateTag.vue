<template>
 <div>
   <div class="col-md-6">
     <form @submit.prevent="createTag">
       <div class="form-group">
         <label>Название</label>
         <input type="text" class="form-control" v-model="tag.title">
       </div>
       <button type="submit" class="btn btn-primary">Создать</button>
     </form>
   </div>
 </div>
</template>

<script>
export default {
  data() {
    return {
      tag: {}
    }
  },
  methods: {
    createTag () {
      this.axios
        .post('/api/tags', this.tag)
        .then(response => (
          this.$router.push({ name: 'tags.index' })
        ))
    },
  },
};
</script>

<style scoped>

</style>