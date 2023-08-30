<template>
    <div class="d-flex justify-content-between flex-wrap flex-mdnowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">LIST LAPORAN</h1>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <table class="table table-striped table-bordered mt4">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th scope="col">Nama Laporan</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td>Laporan Aktivitas Gym Bulanan</td>
                                    <td class="text-center">
                                        <button @click.prevent="print()" class="btn btn-info">CETAK</button>
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>Laporan Kinerja Instruktur Bulanan</td>
                                    <td class="text-center">
                                        <button @click.prevent="" class="btn btn-info">CETAK</button>
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>Laporan Aktivitas Kelas Bulanan</td>
                                    <td class="text-center">
                                        <button @click.prevent="printKelas()" class="btn btn-info">CETAK</button>
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>Laporan Pendapatan Per Bulan</td>
                                    <td class="text-center">
                                        <button @click.prevent="" class="btn btn-info">CETAK</button>
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
import {  ref } from 'vue'
//import { useToast } from "vue-toastification";
import { format } from 'date-fns';
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
export default {
    setup() {
        let printPdf = ref([])   
        const token = localStorage.getItem('token')
        
        //let toast = useToast();
        /*onMounted(() => {
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/kelas')
            .then(response => {
                kelas.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
            
        })*/

        function print(){
            //let toast = useToast();
            pdfMake.vfs = pdfFonts.pdfMake.vfs;
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/laporan')
            .then(response => {
                const laporanData = response.data; // Assuming the response contains an array of laporan data
      
                const currentDate = new Date();
                const currentMonth = currentDate.toLocaleString('default', { month: 'long' });
                const currentYear = currentDate.getFullYear();

                const formattedDate = format(currentDate, 'dd MMMM yyyy');

                // Calculate the total jumlah_member
                const totalJumlahMember = laporanData.reduce((sum, item) => sum + item.jumlah_member, 0);

                const docDefinition = {
                    content: [
                    {
                        text: 'GoFit',
                        style: 'header'
                    },
                    'Jl. Centralpark No. 10 Yogyakarta\n\n',
                    {
                        text: 'LAPORAN AKTIVITAS GYM Bulanan',
                        style: 'subHeader'
                    },
                    {
                        text: `Bulan: ${currentMonth} Tahun: ${currentYear}\n`,
                        style: 'subSubHeader'

                    },
                    `Tanggal cetak: ${formattedDate}`,
                    '\n',
                    {
                        style: 'table',
                        table: {
                        widths: ['auto', 'auto'],
                        headerRows: 1,
                        body: [
                            ['Tanggal', 'Jumlah Member'],
                            ...laporanData.map(item => [item.tanggal, item.jumlah_member]),
                            [{ text: 'TOTAL', bold: true },{ text: `${totalJumlahMember}`, bold: true }]
                        ]
                        }
                    }
                    ],
                    styles: {
                    header: {
                        fontSize: 18,
                        bold: true,
                        margin: [0, 0, 0, 10],
                        border: [true, true, true, true]
                    },
                    subHeader: {
                        fontSize: 18,
                        bold: true,
                        margin: [0, 0, 0, 10],
                        border: [true, true, true, true],
                        decoration: 'underline',
                    },
                    subSubHeader: {
                        fontSize: 14,
                        margin: [0, 0, 0, 10],
                        border: [true, true, true, true],
                        decoration: 'underline',
                    },
                    table: {
                        margin: [0, 10, 0, 10],
                        table: {
                            widths: ['auto', 'auto'],
                            body: [
                            [{ text: '', border: [true, true, false, false] }, { text: '', border: [false, true, true, false] }],
                            [{ text: '', border: [true, false, false, false] }, { text: '', border: [false, false, true, false] }]
                            ]
                        },
                        hLineWidth: function(i, node) {
                            return i === 0 || i === node.table.body.length ? 2 : 1;
                        },
                        vLineWidth: function(i, node) {
                            return i === 0 || i === node.table.widths.length ? 2 : 1;
                        },
                        hLineColor: function(i, node) {
                            return i === 0 || i === node.table.body.length ? 'black' : 'gray';
                        },
                        vLineColor: function(i, node) {
                            return i === 0 || i === node.table.widths.length ? 'black' : 'gray';
                        }
                    }
                    }
                };

                pdfMake.createPdf(docDefinition).open();
            }).catch(error => {
                console.log(error.response.data)
            })
        }

        function printKelas(){
            //let toast = useToast();
            pdfMake.vfs = pdfFonts.pdfMake.vfs;
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/laporankelas')
            .then(response => {
                const laporanData = response.data; // Assuming the response contains an array of laporan data
      
                const currentDate = new Date();
                const currentMonth = currentDate.toLocaleString('default', { month: 'long' });
                const currentYear = currentDate.getFullYear();

                const formattedDate = format(currentDate, 'dd MMMM yyyy');

                // Calculate the total jumlah_member
                //const totalJumlahMember = laporanData.reduce((sum, item) => sum + item.jumlah_member, 0);

                const docDefinition = {
                    content: [
                    {
                        text: 'GoFit',
                        style: 'header'
                    },
                    'Jl. Centralpark No. 10 Yogyakarta\n\n',
                    {
                        text: 'LAPORAN AKTIVITAS KELAS BULANAN',
                        style: 'subHeader'
                    },
                    {
                        text: `Bulan: ${currentMonth} Tahun: ${currentYear}\n`,
                        style: 'subSubHeader'
                    },
                    `Tanggal cetak: ${formattedDate}`,
                    '\n',
                    {
                        table: {
                        widths: ['auto', 'auto', 'auto'],
                        headerRows: 1,
                        body: [
                            [{text: 'Kelas', bold: true }, {text: 'Nama Instruktur', bold: true }, {text: 'Jumlah Peserta', bold: true }],
                            ...laporanData.map(item => [item.nama_kelas, item.nama_instruktur, item.jumlah_member])
                        ],
                        style: 'tableStyle'
                        }
                    }
                    ],
                    styles: {
                    header: {
                        fontSize: 18,
                        bold: true,
                        margin: [0, 0, 0, 10]
                    },
                    subHeader: {
                        fontSize: 18,
                        bold: true,
                        margin: [0, 0, 0, 10],
                        decoration: 'underline',
                    },
                    subSubHeader: {
                        fontSize: 14,
                        margin: [0, 0, 0, 10],
                        decoration: 'underline',
                    },
                    tableStyle: {
                        margin: [0, 10, 0, 10],
                        layout: {
                        hLineWidth: function (i, node) {
                            return (i === 0 || i === node.table.body.length) ? 2 : 1;
                        },
                        vLineWidth: function (i, node) {
                            return (i === 0 || i === node.table.widths.length) ? 2 : 1;
                        },
                        },
                    }
                    }
                };

                pdfMake.createPdf(docDefinition).open();
            }).catch(error => {
                console.log(error.response.data)
            })
        }

        //method delete
        /*function kelasDelete(id) {
            axios.delete(`http://localhost:8000/api/kelas/${id}`)
            .then(() => {
                        toast.error("Berhasil Hapus Data !",{
                            timeout: 2000
                        })
                        kelas.value.splice(kelas.value.indexOf(id), 1);
            }).catch(error => {
                console.log(error.response.data)
            })
        }*/
        return {
            printPdf,
            //kelasDelete, 
            print, 
            printKelas
        }
    }
}
</script>
<style>
</style>