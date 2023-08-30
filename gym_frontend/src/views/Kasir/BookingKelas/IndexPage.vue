<template>
    <div class="d-flex justify-content-between flex-wrap flex-mdnowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">LIST BOOKING KELAS</h1>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <table class="table table-striped table-bordered mt4">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th scope="col">No Booking Kelas</th>
                                    <th scope="col">Nama Member</th>
                                    <th scope="col">Nama Instruktur</th>
                                    <th scope="col">Nama Kelas</th>
                                    <th scope="col">Jenis Kelas</th>
                                    <th scope="col">Status Hadir</th>
                                    <th scope="col">Tanggal Booking</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(booking, id) in booking" :key="id" class="text-center">
                                    <td>{{ booking.no_booking }}</td>
                                    <td>{{ booking.member.nama }}</td>
                                    <td>{{ booking.instruktur.nama }}</td>
                                    <td>{{ booking.kelas.nama_kelas }}</td>
                                    <td v-if="booking.jenis_kelas=='1'">Paket</td>
                                    <td v-else-if="booking.jenis_kelas=='0'">Reguler</td>
                                    <td v-if="booking.status_hadir=='1'">
                                        Hadir
                                    </td>
                                    <td v-else-if="booking.status_hadir=='0'">
                                        Tidak Hadir
                                    </td>
                                    <td>{{ booking.tanggal_booking }}</td>
                                    <td v-if="booking.jenis_kelas=='1'" class="text-center">
                                        <button @click.prevent="print(booking.id)" class="btn btn-info">CETAK</button>
                                    </td>
                                    <td v-else class="text-center">
                                        <button @click.prevent="printReguler(booking.id)" class="btn btn-info">CETAK</button>
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
import { reactive,onMounted, ref } from 'vue'
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
//import { useRouter} from "vue-router";
//import { useToast } from "vue-toastification";
export default {
    setup() {
        let booking = ref([])
        const printPdf = reactive({
                no_struk: "",
                tanggal: "",
                member: "",
                instruktur: "",
                kelas: "",
                sisa_deposit_kelas: "",
        });
        //let searchQuery = ref([])
        //state validation
        //const validation = ref([]);
            //vue router
            //const router = useRouter();
            //params id
        const token = localStorage.getItem('token')
        onMounted(() => {
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/BookingKelas')
            .then(response => {
                booking.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
            
        })

        /*function search(){
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/instrukturSearch', {
                params: {
                    query : searchQuery.value
                }
            }).then(response => {
                instruktur.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
        }*/

        function print(id){
            //let toast = useToast();
            pdfMake.vfs = pdfFonts.pdfMake.vfs;
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            //get API from Laravel Backend
            axios
                .get("http://localhost:8000/api/BookingKelas/" + id,)
                .then(response => {
                    //assign state posts with response data
                    printPdf.no_struk = response.data.data.no_booking
                    printPdf.tanggal = response.data.data.tanggal_booking
                    printPdf.member = response.data.data.member.nama
                    printPdf.instruktur = response.data.data.instruktur.nama
                    printPdf.kelas = response.data.data.kelas.nama_kelas
                    printPdf.sisa_deposit_kelas = response.data.data.deposit_kelas.total_kelas
                }).catch(error => {
                    console.log(error.response.data)
                })

            const docDefinition = {
                content: [
                    {
                        text: 'Gofit',
                        style: 'header'
                    },
                    'Jl. Centralpark No. 10 Yogyakarta\n\n',
                    {
                        text: 'STRUK PRESENSI KELAS PAKET',
                        style: 'header'
                    },
                    'No Struk : ' + printPdf.no_struk,
                    'Tanggal : ' + printPdf.tanggal + '\n\n',
                    {
                        text: 'Member : ' + printPdf.member,
                        style: 'header'
                    },
                    'kelas : ' + printPdf.kelas,
                    'instruktur : ' + printPdf.instruktur,
                    'Sisa Deposit : '+ printPdf.sisa_deposit_kelas
                ],
                styles:{
                    header: {
                        fontSize: 18,
                        bold: true,
                        margin: [0, 0, 0, 10]
                    }
                }
            }
            pdfMake.createPdf(docDefinition).open();
        }

        function printReguler(id){
            //let toast = useToast();
            pdfMake.vfs = pdfFonts.pdfMake.vfs;
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            //get API from Laravel Backend
            axios
                .get("http://localhost:8000/api/BookingKelas/" + id,)
                .then(response => {
                    //assign state posts with response data
                    printPdf.no_struk = response.data.data.no_booking
                    printPdf.tanggal = response.data.data.tanggal_booking
                    printPdf.member = response.data.data.member.nama
                    printPdf.instruktur = response.data.data.instruktur.nama
                    printPdf.kelas = response.data.data.kelas.nama_kelas
                    printPdf.sisa_deposit_kelas = response.data.data.kelas.harga_kelas
                }).catch(error => {
                    console.log(error.response.data)
                })

            const docDefinition = {
                content: [
                    {
                        text: 'Gofit',
                        style: 'header'
                    },
                    'Jl. Centralpark No. 10 Yogyakarta\n\n',
                    {
                        text: 'STRUK PRESENSI KELAS PAKET',
                        style: 'header'
                    },
                    'No Struk : ' + printPdf.no_struk,
                    'Tanggal : ' + printPdf.tanggal + '\n\n',
                    {
                        text: 'Member : ' + printPdf.member,
                        style: 'header'
                    },
                    'kelas : ' + printPdf.kelas,
                    'instruktur : ' + printPdf.instruktur,
                    'Harga Kelas : '+ printPdf.sisa_deposit_kelas
                ],
                styles:{
                    header: {
                        fontSize: 18,
                        bold: true,
                        margin: [0, 0, 0, 10]
                    }
                }
            }
            pdfMake.createPdf(docDefinition).open();
        }

        /*function instrukturUpdate(id) {
                let status = 1;
                let toast = useToast();
                axios
                    .put("http://localhost:8000/api/IzinInstrukturStatus/" + id, {
                        status_izin : status
                    })
                    .then(() => {
                        toast.success("Berhasil Konfirmasi Izin !",{
                            timeout: 2000
                        })
                        //redirect ke post index
                        router.push({
                            name: "mo.izin.index",
                        });
                    })
                    .catch((error) => {
                        //assign state validation with error
                        validation.value = error.response.data;
                    });
            }*/

        //method delete
        /*function instrukturDelete(id) {
            axios.delete(`http://localhost:8000/api/instruktur/${id}`)
            .then(() => {
                        toast.error("Berhasil Hapus Data !",{
                            timeout: 2000
                        })
                    instruktur.value.splice(instruktur.value.indexOf(id), 1);
            }).catch(error => {
                console.log(error.response.data)
            })
        }*/
        return {
            booking,
            printPdf,
            print,
            printReguler
            //instrukturUpdate
            //searchQuery,
            //instrukturDelete,
            //search
        }
    }
}
</script>
<style>
</style>