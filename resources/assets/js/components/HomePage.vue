<template>
    <ul class="chat">
        <li class="left clearfix" v-for="user in users">
            <div class="chat-body clearfix">
                <div class="header">
                    <strong class="primary-font">
                        {{ user.name }}
                    </strong>
                </div>
            </div>
        </li>
    </ul>
</template>

<script>
  export default {
    props: ['users']
  };
</script>