<template>
    <li class="icons dropdown">
        <a href="javascript:void(0)" data-toggle="dropdown">
            <i class="mdi mdi-email-outline"></i>
            <span class="badge badge-pill gradient-1">{{total_count}}</span>
        </a>
        <div class="drop-down animated fadeIn dropdown-menu">
            <div class="dropdown-content-heading d-flex justify-content-between">
                <span class="">{{total_count}} New Messages</span>  
                <a :href="'/messenger'" class="d-inline-block">
                    View All
                </a>
            </div>
            <div class="dropdown-content-body">
                <ul v-if="connects.length > 0">
                    <li class="notification-unread" v-for="msg in connects" :key="msg.id" v-if="msg.unreadMsgs != null">
                        <a href="javascript:void()">
                            <img class="float-left mr-3 avatar-img" style="width: 40px;height: 40px;" :src="'images/employees/'+msg.photo" alt=""> 
                            <div class="notification-content">
                                <div class="notification-heading text-capitalize">
                                    <span class="badge badge-pill gradient-1">{{msg.unreadMsgsCount}}</span>
                                    {{msg.name}}
                                </div>
                                <div class="notification-timestamp" v-if="msg.last_active && msg.last_active != true">{{changeTimeFormat(msg.last_active )}}</div>
                                <div class="notification-timestamp" v-if="msg.last_active === true">Online</div>
                                <div class="notification-text">{{msg.unreadMsgs.message}}</div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </li>
</template>

<script>
import moment from 'moment'
import tz from 'moment-timezone'
    export default {
        props: ['user'],

        data() {
            return {
                me: JSON.parse(this.user).id,
                newMessage: '',
                messages: [],
                users: [],
                searchResults: [],
                selectedUser: '',
                receiver: '',
                chat_with: '',
                last_active: '',
                total_count: 0,
                connects: [],
            }
        },

        created(){
            this.connectselected();
            this.getConnects();
        },
        methods: {

            checkValidDate(date){
                return moment(date, true).isValid(); // true
            },

            changeTimeFormat(date){
                if(moment(date, true).isValid()){
                    return moment.tz(date, "Asia/Karachi").fromNow()
                }
                else{
                    return '-'
                }
            },

            getConnects(){
                axios
                    .get('/get-connects-navbar')
                    .then(res => {
                        this.connects = res.data
                        console.log(this.connects)
                        if(this.connects.length > 0){
                            this.msgsCount()
                        }
                    })
                    .catch(err => alert(err))
            },

            msgsCount(){
                this.total_count = 0
                this.connects.forEach(co =>  {
                    this.total_count += co.unreadMsgsCount
                })
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
                Echo.join('MessengerTextSent-'+this.me)
                    .listen('MessengerText', (event) => {
                        let ind = this.connects.findIndex((obj => obj.id == event.chat.user_id))
                        console.log(ind)
                        if(ind > -1){
                            this.connects[ind].unreadMsgsCount = parseInt(this.connects[ind].unreadMsgsCount) + parseInt(1)
                        }else{
                            let newConnect = {
                                'id' : event.chat.sender.id,
                                'name' : event.chat.sender.name,
                                'last_active' : event.chat.sender.last_active,
                                'photo' : event.chat.sender.photo,
                                'unreadMsgsCount': 1,
                                'unreadMsgs': event.chat
                            }
                            this.connects.push(newConnect)
                        }
                        this.msgsCount()
                        new Audio("/sounds/awareness.mp3").play()
                });
        },

    },

    
}
</script>
