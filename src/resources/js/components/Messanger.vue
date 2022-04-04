<template>
    <section>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="d-block d-sm-none">
                    <button data-toggle="collapse" class="btn btn-block btn-secondary my-1 text-left" data-target="#demo">
                            Connects List <i class="icon-menu float-right pt-1"></i>
                    </button>
                    <div id="demo" class="collapse people-list my-2">
                        <div class="card p-2">
                            <h6 class="py-1">Connects List</h6>
                            <v-select 
                                @search="searchUser"
                                :options="searchResults" 
                                label="name" 
                                v-model="selectedUser"
                                placeholder="Search"
                            >
                            </v-select>
                            <ul class="list-unstyled chat-list mt-2 mb-0">
                                <li class="clearfix" v-for="(user, index) in this.connects" :key="index" @click="fetchMessages(user)">
                                    <img :src="'/images/employees/'+user.photo" alt="avatar" v-if="user.photo != null">
                                    <div class="about" >
                                        <div class="name">
                                            {{user.name}}
                                            <span class="badge badge-pill gradient-1" v-if="user.unreadMsgsCount > 0" style="width: 18px;">{{user.unreadMsgsCount}}</span>    
                                        </div>
                                        <div class="status" v-if="user.last_active == true"> 
                                            <span v-if="user.typing" class="badge bg-yellow text-white">typing...</span>
                                            <i class="fa fa-circle online"></i> online 
                                        </div>
                                        <div class="status" v-if="user.last_active && user.last_active != true"> 
                                            <i class="fa fa-circle offline"></i> <small>Active: {{changeTimeFormat(user.last_active )}}</small> 
                                        </div>
                                        <div class="status" v-if="!user.last_active"> <i class="fa fa-circle offline"></i> offline </div>                                            
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card chat-app">
                    <div id="plist" class="people-list">
                            <v-select 
                                @search="searchUser"
                                :options="searchResults" 
                                label="name" 
                                v-model="selectedUser"
                                placeholder="Search"
                            >
                            </v-select>
                        <ul class="list-unstyled chat-list mt-2 mb-0">
                            <li class="clearfix" v-for="(user, index) in this.connects" :key="index" @click="fetchMessages(user)">
                                <img :src="'/images/employees/'+user.photo" alt="avatar" v-if="user.photo != null">
                                <div class="about" >
                                    <div class="name">
                                        {{user.name}}
                                        <span class="badge badge-pill gradient-1" v-if="user.unreadMsgsCount > 0" style="width: 18px;">{{user.unreadMsgsCount}}</span>    
                                    </div>
                                    <div class="status" v-if="user.last_active == true"> 
                                        <span v-if="user.typing" class="badge bg-yellow text-white">typing...</span>
                                        <i class="fa fa-circle online"></i> online 
                                    </div>
                                    <div class="status" v-if="user.last_active && user.last_active != true"> 
                                        <i class="fa fa-circle offline"></i> <small>Active: {{changeTimeFormat(user.last_active )}}</small> 
                                    </div>
                                    <div class="status" v-if="!user.last_active"> <i class="fa fa-circle offline"></i> offline </div>                                            
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="chat">
                        <div class="chat-header clearfix">
                            <div class="row">
                                <div class="col-lg-6">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info" v-if="photo_chat_with != null">
                                        <img :src="'/images/employees/'+photo_chat_with" alt="avatar">
                                    </a>
                                    <div class="chat-about">
                                        <h6 class="m-b-0">{{chat_with}}</h6>
                                        <small v-if="last_active == true">
                                            <i class="fa fa-circle online"></i> online 
                                        </small>
                                        <small v-if="checkValidDate(last_active) == true">Active: {{changeTimeFormat(last_active)}}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-history" id="chat-history" ref="chatHistory">
                            <ul class="m-b-0">
                                <li class="clearfix" v-for="msg in messages" :key="msg.id">
                                    <div class="message-data" :class="{'text-right' : msg.user_id == user.id}">
                                        <span class="message-data-time">{{changeTimeFormat(msg.created_at)}}</span>
                                    </div>
                                    <div class="message" :class="{'float-right my-message' : msg.user_id == user.id, 'other-message' : msg.user_id != user.id}">
                                        {{msg.message}}
                                    </div>  
                                    <!-- <i class="fas fa-check message-data-time text-right float-right" v-if="msg.msg_read == 0 && msg.user_id == user.id"></i> -->
                                </li>                               
                            </ul>
                        </div>
                        <div class="chat-message clearfix">
                            <div class="input-group mb-0">
                                <div class="input-group-prepend" @click="sendMessage()" :disabled="chat_with == '' || !chat_with">
                                    <span class="input-group-text"><i class="fa fa-send"></i></span>
                                </div>
                                <input 
                                    v-model="newMessage"
                                    @keyup.enter="sendMessage()"
                                    :disabled="chat_with == '' || !chat_with"
                                    type="text" 
                                    class="form-control" 
                                    placeholder="Enter text here...">                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import moment from 'moment'
import tz from 'moment-timezone'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
import axios from 'axios'
    export default {
        components: {
            vSelect,
        },
        props: ['user'],

        data() {
            return {
                newMessage: '',
                messages: [],
                users: [],
                searchResults: [],
                selectedUser: '',
                receiver: '',
                chat_with: '',
                photo_chat_with: null,
                last_active: '',
                connects: [],
                channel: null,
            }
        },

        created(){
            this.connectselected();
            this.getConnects();
        },

        watch: {

            selectedUser(after, before) {
                this.fetchMessages(after)
            },


        },

        methods: {

            getConnects(){
                axios
                    .get('/get-connects')
                    .then(res => this.connects = res.data)
                    .catch(err => alert(err))
            },

            connectselected() {

                Echo.join('messenger')
                .here(users => {
                    this.users = users;
                    this.users = this.users.filter(u => u.id !== this.user.id);
                    this.users.forEach(user => {
                        this.connects.find(r => {
                            if(r.id == user.id){
                                r.last_active = true
                            }
                        })
                    })

                })
                .joining(user => {
                    this.users.push(user);
                    this.users.forEach(user => {
                        this.connects.find(r => {
                            if(r.id == user.id){
                                r.last_active = true
                            }
                        })
                    })
                })
                .leaving(user => {
                    this.users = this.users.filter(u => u.id !== user.id);
                    this.connects.find(r => {
                        if(r.id == user.id){
                            r.last_active = moment.tz("Asia/Karachi").fromNow()
                        }
                    })
                    axios
                        .post('/last-active/'+user.id)
                        .catch(err => alert(err))
                })
                // console.log()
                Echo.join('MessengerTextSent-'+this.user.id)
                    .listen('MessengerText', (event) => {
                        if(this.receiver == event.chat.user_id){
                                this.messages.push({
                                    message: event.chat.message,
                                    user: event.chat.user_id,
                                    created_at: moment.tz('Asia/Karachi')
                                });
                            
                            this.scrollToBottom();
                            
                            }else{
                                
                                let ind = this.connects.findIndex((obj => obj.id == event.chat.user_id))
                                // console.log(ind)
                                if(ind > -1){
                                    this.connects[ind].unreadMsgsCount = parseInt(this.connects[ind].unreadMsgsCount) + parseInt(1)
                                }else{
                                    let newConnect = {
                                        'id' : event.chat.sender.id,
                                        'name' : event.chat.sender.name,
                                        'last_active' : event.chat.sender.last_active,
                                        'photo' : event.chat.sender.photo,
                                        'unreadMsgsCount': 1,
                                    }
                                    this.connects.push(newConnect)
                                }

                            }
                });
        },

        searchUser(search, loading){
            if(search.length) {
                loading(true)    
                axios
                    .get('/searchChat/'+search)
                    .then(res => {
                        this.searchResults = res.data
                        loading(false)
                    })
                    .catch(err => alert(err))
                }

        },

        fetchMessages(user){
            this.messages = []
            this.receiver = user.id
            this.chat_with = user.name
            this.photo_chat_with = user.photo
            this.last_active = user.last_active
            axios
                .get('/fetch-messages/'+ this.receiver)
                .then(res => {
                    if(res.data.length > 0){
                        this.messages = res.data
                        axios
                            .post('/msg-seen/'+this.receiver)
                            .then(res => {
                                    let ind = this.connects.findIndex((obj => obj.id == this.receiver))
                                    this.connects[ind].unreadMsgsCount = 0

                            })
                            .catch(err => alert(err))
                        }
                    })
                .catch(err => alert(err))

        },

        scrollToBottom(){
            setTimeout(() => {
                    this.$refs.chatHistory.scrollTop = this.$refs.chatHistory.scrollHeight - this.$refs.chatHistory.clientHeight;
                }, 50);
        },

        checkValidDate(date){
            return moment(date, true).isValid(); // true
        },

        changeTimeFormat(date){
            return moment.tz(date, "Asia/Karachi").fromNow()
        },
        

        sendMessage() {
            if(this.newMessage != ''){
                axios.post('/sendMessengerText/'+this.receiver, { 
                        message: this.newMessage,
                        channel: this.channel
                    });
                // alert(this.receiver + '/' + this.newMessage + '/' + this.channel)
                this.messages.push({
                        message: this.newMessage,
                        user_id: this.user.id,
                        receiver_id: this.receiver,
                        created_at: moment.tz('Asia/Karachi')
                    });
                    
                this.scrollToBottom()
                    
                this.newMessage = '';

            }
        }
    },

    
}
</script>

<style>

.chat-app .people-list {
    width: 280px;
    position: absolute;
    left: 0;
    top: 0;
    padding: 20px;
    z-index: 7;
    height: 65vh;
    overflow-y: auto;
}

.chat-app .chat {
    margin-left: 280px;
    border-left: 1px solid #eaeaea
}

.people-list {
    -moz-transition: .5s;
    -o-transition: .5s;
    -webkit-transition: .5s;
    transition: .5s
}

.people-list .chat-list li {
    padding: 10px 15px;
    list-style: none;
    border-radius: 3px
}

.people-list .chat-list li:hover {
    background: #efefef;
    cursor: pointer
}

.people-list .chat-list li.active {
    background: #efefef
}

.people-list .chat-list li .name {
    font-size: 15px
}

.people-list .chat-list img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 3px solid #fff;
}

.people-list img {
    float: left;
    border-radius: 50%
}

.people-list .about {
    float: left;
    padding-left: 8px
}

.people-list .status {
    color: #999;
    font-size: 13px
}

.chat .chat-header {
    padding: 15px 20px;
    border-bottom: 2px solid #f4f7f6
}

.chat .chat-header img {
    float: left;
    border: 3px solid #fff;
    border-radius: 50%;
    width: 40px;
    height: 40px;
}

.chat .chat-header .chat-about {
    float: left;
    padding-left: 10px
}

.chat .chat-history {
    padding: 20px;
    border-bottom: 2px solid #fff;
    height: 65vh;
    overflow-y: auto;
    display: flex;
    flex-direction: column-reverse;
}

.chat .chat-history ul {
    padding: 0
}

.chat .chat-history ul li {
    list-style: none;
    margin-bottom: 30px
}

.chat .chat-history ul li:last-child {
    margin-bottom: 0px
}

.chat .chat-history .message-data {
    margin-bottom: 15px
}

.chat .chat-history .message-data img {
    border-radius: 40px;
    width: 40px
}

.chat .chat-history .message-data-time {
    color: #434651;
    padding-left: 6px
}

.chat .chat-history .message {
    color: #444;
    padding: 18px 20px;
    line-height: 26px;
    font-size: 16px;
    border-radius: 7px;
    display: inline-block;
    position: relative
}

.chat .chat-history .message:after {
    bottom: 100%;
    left: 7%;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
    border-bottom-color: #fff;
    border-width: 10px;
    margin-left: -10px
}

.chat .chat-history .other-message {
    background: #efefef
}

.chat .chat-history .other-message:after {
    bottom: 100%;
    left: 30px;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
    border-bottom-color: #efefef;
    border-width: 10px;
    margin-left: -10px
}

.chat .chat-history .my-message {
    background: #e8f1f3;
    text-align: right
}

.chat .chat-history .my-message:after {
    border-bottom-color: #e8f1f3;
    left: 65%
}

.chat .chat-message {
    padding: 20px
}

.online,
.offline,
.me {
    margin-right: 2px;
    font-size: 8px;
    vertical-align: middle
}

.online {
    color: #86c541
}

.offline {
    color: #e47297
}

.me {
    color: #1d8ecd
}

.float-right {
    float: right
}

.clearfix:after {
    visibility: hidden;
    display: block;
    font-size: 0;
    content: " ";
    clear: both;
    height: 0
}

@media only screen and (max-width: 767px) {
    .chat-app .people-list {
        height: 465px;
        width: 100%;
        overflow-x: auto;
        background: #fff;
        left: -400px;
        display: none
    }
    .chat-app .people-list.open {
        left: 0
    }
    .chat-app .chat {
        margin: 0
    }
    .chat-app .chat .chat-header {
        border-radius: 0.55rem 0.55rem 0 0
    }
    .chat-app .chat-history {
        height: 550px;
        overflow-x: auto
    }
}

@media only screen and (min-width: 768px) and (max-width: 992px) {
    .chat-app .chat-list {
        height: calc(60vh - 25px);
        overflow-x: auto
    }
    .chat-app .chat-history {
        height: calc(60vh - 25px);
        overflow-x: auto
    }
}

@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
    .chat-app .chat-list {
        height: calc(68vh - 250px);
        overflow-x: auto
    }
    .chat-app .chat-history {
        /* height: calc(100vh - 350px); */
        height: calc(68vh - 250px);
        overflow-x: auto
    }
}
</style>