<!-- Vue component -->
<template>
    <div class="mb-3">
        <multiselect v-model="selectedUsers" id="ajax" label="name" track-by="id" placeholder="Type to search" open-direction="bottom" :options="users" :multiple="true" :searchable="true" :loading="isLoading" :internal-search="false" :clear-on-select="false" :close-on-select="false" :options-limit="300" :limit="3" :limit-text="limitText" :max-height="600" :show-no-results="false" :hide-selected="true" @search-change="asyncFind">
            <template slot="tag" slot-scope="{ option, remove }"><span class="userselect__tag"><span>{{ option.name }}</span><span class="userselect__remove" @click="remove(option)">❌</span></span></template>
            <template slot="clear" slot-scope="props">
                <div class="userselect__clear" v-if="selectedUsers.length" @mousedown.prevent.stop="clearAll(props.search)"></div>
            </template><span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
        </multiselect>
        <input type="hidden" v-model="selectValue" name="users"/>
    </div>
</template>

<script>

import Multiselect from 'vue-multiselect'

export default {
    props: {
        value: Array,
        role: String
    },
    components: {
        Multiselect
    },
    data () {
        return {
            selectedUsers: [],
            users: [],
            isLoading: false
        }
    },
    created() {
        this.selectedUsers =  this.value
    },
    methods: {
        limitText (count) {
            return `and ${count} other users`
        },
        asyncFind (query) {
            this.isLoading = true

            axios
                .get("/resources/users/"+this.role,{ params: { q: query }})
                .then(response => {
                    this.isLoading = false
                    this.users = response.data.data;
                })
                .catch(error => {
                    // eslint-disable-next-line
                    console.log(error);
                });
        },
        clearAll () {
            this.selectedUsers = []
        }
    },
    computed: {
        selectValue() {
            // `this` points to the component instance
            return JSON.stringify(this.selectedUsers)
        }
    }
}
</script>

