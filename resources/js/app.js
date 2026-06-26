
import Alpine from 'alpinejs'
import axios from 'axios'
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/dist/sweetalert2.min.css'

import { ComfirmAlert, CustomAlert } from './alerts/alertCustom';


const btn = document.getElementById('logout');
const form = document.getElementById('form');
const btnClose = document.getElementById('btnClose')

btn.addEventListener('click', () => {
    form.classList.remove('hidden');
});

btnClose.addEventListener('click', () => {
    form.classList.add('hidden');
});


window.Alpine = Alpine
Alpine.start()
window.axios = axios;
window.Swal = Swal
ComfirmAlert()
CustomAlert()
