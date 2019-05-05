<template>
    <div>
        <form @submit.prevent="updateComment">
            <p>Тема<br>
                <input type="text" class="form-control" v-model="comment.title">
            <p>Комментарий:<br>
                <textarea class="form-control" v-model="comment.body" rows="5"></textarea>
            </p>
            <br>
            <input type="file" name="image">
            <button class="btn btn-primary">Добавить комментарий</button>
        </form>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                comment: {}
            }
        },
        created() {

            console.log('123')
            // let uri = 'comment/show';
            // axios.get(uri).then(response => {
            //     this.comments = response.data;
            // });
        },
        methods: {
            updateComment() {
                axios.post('/api/auth/comment/update', this.comment).then(res => {
                    this.postData = res.data;
                    // Event.$emit('added_comment', this.postData);
                }).catch(e => {
                    console.log(e);
                });
                this.body = '';
                this.title = '';
            }
        }
    }
</script>

<style scoped>

</style>