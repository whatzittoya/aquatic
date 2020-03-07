<template>
    <div>
        <!-- <modal v-if="showModal" @close="showModal = false" v-bind:test='form'> -->
        <!-- <modal v-if="showModal" @close="showModal = false"  :edit="edit" :id="id" >
   
  </modal> -->

        <div class="row">

            <div class="col-md-12">
                <v-card-title>
                    Pembayaran
                    <v-spacer></v-spacer>
                </v-card-title>
                <v-data-table :headers="headers" :items="payments" :items-per-page="10" class="elevation-1"
                    :search="search">
                    <template v-slot:item.verified="{ item }">
                        {{item.verified ? "Sudah diverifikasi":"Belum diverifikasi"}}
                    </template>
                    <template v-slot:top>
                        <v-toolbar flat color="white">
                            <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details>
                            </v-text-field>

                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-spacer></v-spacer>
                            <v-dialog v-model="dialog" max-width="500px">
                                <template v-slot:activator="{ on }">
                                    <v-btn color="primary" dark class="mb-2" v-on="on">Tambah Pembayaran</v-btn>
                                </template>
                                <v-card>
                                    <v-form @keyup.native.enter="save">
                                        <v-card-title>
                                            <span class="headline">{{ formTitle }}</span>
                                        </v-card-title>

                                        <v-card-text>
                                            <v-container>
                                                <v-row>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-select v-model="form.club" :items="clubs" item-text="name"
                                                            item-value="id" label="Klub"></v-select>

                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-select v-model="form.event" :items="events" item-text="name"
                                                            item-value="id" label="Event"></v-select>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">

                                                        <v-text-field ref="bank_name" v-model="form.bank_name"
                                                            label="Nama Bank" type="text" :rules="[rules_form.required]">
                                                        </v-text-field>
                                                    </v-col>
                                            

                                                    
                                                     <v-col cols="12" sm="12" md="6">
                                                    <v-text-field ref="account_name" v-model="form.account_name"
                                                            label="Nama Pemilik Rekening" type="text" :rules="[rules_form.required]">
                                                        </v-text-field>
                                                    </v-col>
                                                     <v-col cols="12" sm="12" md="6">
                                                    <v-text-field ref="account_number" v-model="form.account_number"
                                                            label="Nomor Rekening" type="text" :rules="[rules_form.required]">
                                                        </v-text-field>
                                                    </v-col>
                                                     <v-col cols="12" sm="12" md="6">
                                                    <v-text-field ref="amount" v-model="form.amount"
                                                            label="Jumlah" type="text" :rules="[rules_form.required]">
                                                        </v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-file-input label="Dokumen"
                                                            accept="image/png, image/jpeg, image/bmp"
                                                            v-model="form.file"
                                                            hint="(extension:jpg,jpeg,png max-size:500KB)"
                                                            persistent-hint :error-messages="file_error_messages">
                                                        </v-file-input>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6" v-if="role == 'admin'">
                            <v-select :items="verified" label="Verifikasi" v-model="form.verified"></v-select>
                          </v-col>
                                                    <v-col cols="12" sm="12" md="6" v-else>
                                                        <b>Verifikasi :</b>
                                                        <div v-if="form.verified">
                                                            <v-chip class="ma-2" color="green" text-color="white" label>
                                                                Sudah diverifikasi </v-chip>
                                                        </div>
                                                        <div v-else>
                                                            <v-chip class="ma-2" color="red" text-color="white" label>
                                                                Belum diverifikasi </v-chip>
                                                        </div>


                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card-text>

                                        <v-card-actions>
                                            <v-spacer></v-spacer>

                                            <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>

                                            <v-btn color="blue darken-1" text @click="save">Save</v-btn>

                                        </v-card-actions>
                                    </v-form>
                                </v-card>
                            </v-dialog>
                        </v-toolbar>
                    </template>

                     <template v-slot:item.amount="{ item }">
                        {{formatRupiah(item.amount)}}
                     </template>
                    <template v-slot:item.action="{ item }">
                        <div v-if="!item.verified">
                        <v-icon small class="mr-2" @click="editData(item)">
                            edit
                        </v-icon>
                        <v-icon small @click="deleteData(item.id)">
                            delete
                        </v-icon>
                        </div>
                        <a :href="'/admin/payments/'+item.id"  target="_blank">
       <v-icon small>
        insert_drive_file
      </v-icon></a>
                    </template>
                </v-data-table>


            </div>
        </div>
        <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="fullPage"></loading>
    </div>

</template>

<!-- script js -->
<script>
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";

export default {
  components: {
    Loading
  },
  computed: {
    formTitle() {
      return this.edit === false ? "New Item" : "Edit Item";
    },

    formtest() {
      return {
        bank_name: this.form.bank_name,
        account_name: this.form.account_name,
        account_number: this.form.account_number,
        amount: this.form.amount
      };
    }
  },

  data() {
    return {
      isLoading: false,
      fullPage: true,
      rules_form: {
        required: value => !!value || "Required."
      },
      menu: false,
      file: null,
      headers: [
        { text: "Klub", value: "clubs.name" },
        { text: "Event", value: "events.name" },
        { text: "Nama Bank", value: "bank_name" },
        { text: "Nama Pemilik Rekening", value: "account_name" },
        { text: "Nomor Rekening", value: "account_number" },
        { text: "Jumlah", value: "amount" },
        { text: "Verifikasi", value: "verified" },
        { text: "Aksi", value: "action", sortable: false }
      ],
      form: {},
      defaultForm: {},
      clubs: [],
      verified: [
        { text: "Belum diverifikasi", value: "0" },
        { text: "Sudah diverifikasi", value: "1" }
      ],

      events: [],
      payments: [],
      file_error_messages: null,
      edit: false,
      search: "",
      id: 0,
      showModal: false,
      dialog: false,
      formHasErrors: false,
      role: ""
    };
  },
  created() {
    this.loadData();
  },
  methods: {
    loadData() {
      // fetch data dari api menggunakan axios
      axios.get("/api/role").then(response => {
        // mengirim data hasil fetch ke varibale array persons
        this.role = response.data.name;
        // console.log(response.data);
      });
      axios.get("/api/payments").then(response => {
        // mengirim data hasil fetch ke varibale array persons
        this.payments = response.data;
        // console.log(response.data);
      });
      axios.get("/api/events").then(response => {
        // mengirim data hasil fetch ke varibale array persons
        this.events = response.data;
        this.form.event = this.events[0].id;
      });
      axios.get("/api/clubs/valid").then(response => {
        // mengirim data hasil fetch ke varibale array persons
        this.clubs = response.data;
        this.form.club = this.clubs[0].id;
      });
      this.defaultForm = {
        club: "",
        event: "",
        bank_name: "",
        account_name: "",
        account_number: "",
        amount: "",
        verified: 0,
        pic_name: ""
      };
      this.form = this.defaultForm;
    },
    fileCheck() {},
    deleteData(id) {
      // delete data
      if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
        axios.delete("/api/payments/" + id).then(response => {
          this.loadData();
        });
      }
    },
    editData(item) {
      // edit data
      this.form = Object.assign({}, item);
      this.form.club = item.club_id;
      this.form.event = item.event_id;
      this.edit = true;
      this.dialog = true;
    },
    createData() {
      // create data
      this.edit = false;
      this.id = 0;
      this.dialog = true;
    },

    save() {
      this.formHasErrors = false;

      Object.keys(this.formtest).forEach(f => {
        if (!this.formtest[f]) this.formHasErrors = true;

        this.$refs[f].validate(true);
      });
      if (!this.formHasErrors && this.file_error_messages == null) {
        const config = {
          headers: { "content-type": "multipart/form-data" }
        };
        // post data ke api menggunakan axios

        let formData = new FormData();

        formData.append("club_id", this.form.club);
        formData.append("event_id", this.form.event);
        formData.append("bank_name", this.form.bank_name);
        formData.append("file", this.form.file);
        formData.append("account_name", this.form.account_name);
        formData.append("account_number", this.form.account_number);
        formData.append("amount", this.form.amount);
        formData.append("verified", this.form.verified);
        formData.append("pic_name", this.form.pic_name);
        //if the data for update
        console.log("save)");
        if (this.edit && this.form.id > 0) {
          this.isLoading = true;
          axios
            .post("/api/payments/updateapi/" + this.form.id, formData, config)
            .then(response => {
              // push router ke read data
              this.loadData();
              this.isLoading = false;
              this.close();
            })
            .catch(errors => {
              this.file_error_messages = errors.response.data.errors.file;
              this.isLoading = false;
            });
        } else {
          this.isLoading = true;
          axios
            .post("/api/payments", formData, config)
            .then(response => {
              // push router ke read data
              this.loadData();
              this.isLoading = false;
              this.close();
            })
            .catch(errors => {
              this.file_error_messages = errors.response.data.errors.file;
              this.isLoading = false;
            });
        }
      }
    },
    close() {
      this.dialog = false;
      this.file_error_messages = "";
      setTimeout(() => {
        this.form = Object.assign({}, this.defaultForm);
        this.edit = false;
        Object.keys(this.formtest).forEach(f => {
          if (!this.formtest[f]) this.formHasErrors = true;
          this.$refs[f].reset();
        });
      }, 300);
    },
    formatRupiah(angka) {
      return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
  },
  watch: {
    dialog(val) {
      val || this.close();
    },
    "form.file"(val) {
      console.log(val);
      if (val != null) {
        this.form.pic_name = val.name;
        if (val.size > 1000000) {
          this.file_error_messages = "File size must be less than 1 MB";
        } else {
          this.file_error_messages = null;
        }
      } else {
        this.file_error_messages = null;
      }
    }
  }
};
</script>