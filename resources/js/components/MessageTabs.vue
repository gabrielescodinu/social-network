<template>
    <div>
        <nav>
            <ul class="nav nav-tabs">
                <li class="nav-item" v-for="(user, index) in users" :key="index">
                    <a class="nav-link" :class="{ active: index === activeTab }" @click="activeTab = index">{{ user.name
                    }}</a>
                </li>
            </ul>
        </nav>
        <div class="tab-content">
            <div class="tab-pane" v-for="(user, index) in users" :key="index" :class="{ active: index === activeTab }">
                <h3>{{ user.name }} messages</h3>
                <ul>
                    <li v-for="(message, index) in filteredMessages(user)" :key="index">
                        <strong>{{ message.subject }}</strong>
                        <p>{{ message.body }}</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
  
<script>
export default {
    props: {
        users: {
            type: Array,
            required: true
        },
        messages: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            activeTab: 0
        }
    },
    methods: {
        filteredMessages(user) {
            return this.messages.filter(message => {
                return message.sender_id === user.id || message.recipient_id === user.id;
            });
        }
    }
}
</script>
  