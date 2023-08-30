<template>
    <div class="d-flex justify-content-between flex-wrap flex-mdnowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">LIST MEMBER</h1>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <div>
                                <input v-model="searchQuery" type="text" form="form-control" placeholder="Cari...."/>
                                <button @click.prevent="search()" class="btn btn-sm btn-primary mr-1">Cari</button>
                            </div>   
                        <table class="table table-striped table-bordered mt4">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th scope="col">Nama Member</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Sisa Deposit Uang</th>
                                    <th scope="col">Telepon</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(member, id) in member" :key="id" class="text-center">
                                    <td>{{ member.nama }}</td>
                                    <td>{{ member.username }}</td>
                                    <td v-if="member.status=='1'">Aktif</td>
                                    <td v-else>Tidak Aktif</td>
                                    <td>{{ member.sisa_deposit_uang }}</td>
                                    <td>{{ member.no_hp }}</td>
                                    <td>{{ member.alamat }}</td>
                                    <td class="text-center">
                                        <router-link :to="{ name: 'kasir.reset.resetPass', params: { id: member.id } }" 
                                        class="btn btn-sm btn-danger ml-1">RESET PASSWORD</router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import { onMounted, ref } from 'vue'
export default {
    setup() {
        let member = ref([])
        let searchQuery = ref([])
        const token = localStorage.getItem('token')
        onMounted(() => {
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/members')
            .then(response => {
                member.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
            
        })
        function search(){
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/membersSearch', {
                params: {
                    query : searchQuery.value
                }
            }).then(response => {
                member.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
        }
        return {
            member,
            searchQuery,
            search
        }
    }
}
</script>
<style>
</style>