<template>
    <div>
        <ul style="list-style: none; padding: 0;">
            <li class="panel-body" v-for="comment in comments">
                <hr>
                <div class="form-group">
                    <div class="list-group-item">
                        <span><h1>{{ comment.title }}</h1></span>
                        <div class="list-group-item"><h4>{{ comment.body }}</h4>
                            <hr>
                            <div><p>created by: {{ comment.user.name }} | {{ comment.createdDate }}</p></div>
                            <button v-if="comment.can_be_deleted" v-on:click="del(comment.id)">Удалить2</button>
                            <button v-if="comment.can_be_modified" id="show-modal"
                                    @click="setVal(comment.id, comment.title, comment.body)">
                                Редактировать
                            </button>
                            <div id="ap2p">
                                <div v-if="showModal">
                                    <transition name="modal">
                                        <div class="modal-mask">
                                            <div class="modal-wrapper">
                                                <div class="modal-dialog">
                                                    <input type="hidden" disabled class="form-control" id="e_id"
                                                           name="id"
                                                           required :value="modalCommentId">
                                                    <div class="modal-content">
                                                        <button type="button" class="close" @click="showModal=false">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        <div v-if="!change_sub_comment">
                                                            <h4 class="modal-title">Title</h4><br>
                                                            <input type="text" id="e_title" required
                                                                   v-model="modalCommentTitle">
                                                        </div>
                                                        <h4 class="modal-title">Body</h4>
                                                        <textarea type="text" id="e_body"
                                                                  v-model="modalCommentBody"></textarea>
                                                        <button class="btn btn-info" @click="editComment()">Сохранить
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div id="form">
                            <form-sub-component :id='comment.id' :title='comment.title'></form-sub-component>
                        </div>
                        <hr>
                        <template>
                            <div v-if="comment.sub_comments" v-for="(sub_comment, index) in comment.sub_comments">
                                <div v-if="index == 0">
                                    <div class="list-group-item"><h4>{{ sub_comment.body }}</h4>
                                        <hr>
                                        <div><p>created by: {{ sub_comment.user.name}} | {{sub_comment.createdDate}}</p>
                                        </div>
                                        <button v-if="sub_comment.can_be_deleted" v-on:click="del(sub_comment.id)">
                                            Удалить
                                        </button>
                                        <button v-if="sub_comment.can_be_modified" id="show-modal3"
                                                @click="setVal(sub_comment.id, sub_comment.title, sub_comment.body, true)">
                                            Редактировать
                                        </button>
                                    </div>
                                    <br>
                                    <button v-if="comment.sub_comments.length > 1" @click="ShowSub">Показать всё
                                    </button>
                                </div>
                                <div v-if="index > 0 && showform2">
                                    <div class="list-group-item"><h4>{{ sub_comment.body }}</h4>
                                        <hr>
                                        <div><p>created by: {{ sub_comment.user.name}} | {{sub_comment.createdDate}}</p>
                                        </div>
                                        <button v-if="sub_comment.can_be_deleted" v-on:click="del(sub_comment.id)">
                                            Удалить
                                        </button>
                                        <button v-if="sub_comment.can_be_modified"
                                                id="show-modal2"
                                                v-on:click="setVal(sub_comment.id, sub_comment.title, sub_comment.body, true)">
                                            Редактировать
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    import Event from '../event.js';
    import axios from 'axios';

    export default {
        data() {
            return {
                showform: false,
                comments: [],
                comment: {},
                showModal: false,
                modalCommentId: null,
                modalCommentTitle: "",
                modalCommentBody: "",
                sub_comment: {},
                auth: {},
                show_sub_comments: false,
                showform2: false,
                change_sub_comment: false
            }
        },
        mounted() {
            Event.$on('added_comment', (comment) => {
                // this.comments.unshift(comment);
                let uri = '/api/auth/comment/show';
                axios.get(uri).then(response => {
                    this.comments = response.data;
                });
            });
        },

        created() {
            let uri = '/api/auth/comment/show';
            axios.get(uri).then(response => {
                this.comments = response.data;
            });
        },
        methods: {
            del(id) {
                let vm = this
                let uri = '/api/auth/comment/delete/' + id;
                axios.get(uri).then(response => {
                    vm.comments = response.data
                });
            },
            setVal(val_id, val_title, val_body, is_sub_comment = false) {
                this.modalCommentId = val_id
                this.modalCommentTitle = val_title
                this.modalCommentBody = val_body
                this.showModal = true;
                this.change_sub_comment = is_sub_comment

            },
            editComment: function () {
                let i_val = this.modalCommentId
                let t_val = this.modalCommentTitle
                let b_val = this.modalCommentBody
                console.log(this.modalCommentId, this.modalCommentTitle, this.modalCommentBody)
                axios.post('/api/auth/comment/update/' + i_val, {val_1: t_val, val_2: b_val})
                    .then(response => {
                        this.showModal = false
                    });
                let uri = '/api/auth/comment/show';
                axios.get(uri).then(response => {
                    this.comments = response.data;
                });
            },
            ShowSub: function () {
                this.showform2 = !this.showform2
            },
        },
    }
</script>

<style lang="scss">
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */
    {
        opacity: 0;
    }

    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

</style>
