<template>
    <div>

        <div class="row">

            <div class="col-md-12">
                <v-card-title>
                    Lomba Event
                    <v-spacer></v-spacer>
                </v-card-title>
                <v-data-table :headers="headers" :items="races" class="elevation-1" :search="search">
                    <template v-slot:top>
                        <v-toolbar flat color="white">
                            <!-- <v-select v-model="event" :items="events" item-text="name" item-value="id"
                                label="event" ></v-select> -->
                     <v-select v-model="event" :items="events"
                                                            item-text="name" item-value="id" label="Pilih Event"
                                                      ></v-select>

                            <v-spacer></v-spacer>
                            <v-dialog v-model="dialog" max-width="500px">
                                <template v-slot:activator="{ on }" >
                                    <v-btn color="primary" dark class="mb-2" v-on="on" :disabled="id=='all' || locked" >Tambah Lomba</v-btn>
                                </template>
                                <v-card>
                                    <v-form @keyup.native.enter="save">
                                        <v-card-title>
                                            <span class="headline">{{ formTitle }}</span>
                                        </v-card-title>

                                        <v-card-text>
                                            <v-container>

                                                <v-row>
 <v-col cols="12" sm="12" md="12">
                                 <v-select v-model="race_selected" :items="races_select"
                                                            item-text="name" item-value="id" label="Lomba"
                                                           return-object ></v-select>
                                                    </v-col>
                                                   
                                                  
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-text-field v-model="form.style" label="Gaya"
                                                            disabled>
                                                        </v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-text-field v-model="form.distance"
                                                            label="Jarak" disabled>
                                                        </v-text-field>
                                                    </v-col>
                                                     <v-col cols="12" sm="12" md="6">
                                                        <v-text-field ref="race_number" v-model="form.race_number"
                                                            label="Nomor" :rules="[races_form.required]" :error-messages="formerrors.race_number">
                                                        </v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-select v-model="form.rules" :items="rules_select" item-text="name"
                                                            item-value="id" label="Kategori" multiple   ></v-select>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-select v-model="form.gender" :items="genders" label="Jenis Kelamin"></v-select>
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
                 
                    <template v-slot:item.action="{ item }" v-if="!locked">
                        <v-icon small class="mr-2" @click="editData(item)">
                            edit
                        </v-icon>
                        <v-icon small @click="deleteData(item.id)">
                            delete
                        </v-icon>


                        <!-- <a :href="'/admin/members/'+member.id" target="_blank" class="btn btn-primary">Lampiran</a> -->
                    </template>
                </v-data-table>
                <!-- <v-select v-model="a.currentItem" :items="items"></v-select> -->
            </div>
           
        </div>
         <loading :active.sync="isLoading" 
        :can-cancel="false" 
   
        :is-full-page="fullPage"></loading>
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
        race_number: this.form.race_number
      };
    },
    locked() {
      var id = this.event;
      try {
        let e = this.events.filter(function(event) {
          return event.id == id;
        });

        return e[0].lock;
      } catch (error) {
        // return 1;
        return 1;
      }
    }
  },

  data() {
    return {
      isLoading: false,
      fullPage: true,
      id: "",
      headers: [
        { text: "Nama", value: "pure_races.name" },
        { text: "Nomor", value: "race_number" },
        { text: "Jenis Kelamin", value: "gender" },
        { text: "Gaya", value: "pure_races.style" },
        { text: "Jarak", value: "pure_races.distance" },
        { text: "Aksi", value: "action", sortable: false }
      ],

      races_form: {
        required: value => !!value || "Required."
      },

      races: [],
      genders: [{ text: "PA" }, { text: "PI" }],
      races: [],
      rules_race: [],
      edit: false,

      showModal: false,

      events: [],
      event: "",
      races_select: [],
      race_selected: [],

      rules_select: [],

      form: {},
      defaultForm: {},
      formerrors: {
        race_number: "",
        name: ""
      },
      search: "",
      dialog: false,
      formHasErrors: false,

      ruletext: ""
    };
  },
  created() {
    this.id = this.$route.params.id;
    this.loadData();
    axios.get("/api/events").then(response => {
      this.events = response.data;
    });
    axios.get("/api/rules").then(response => {
      this.rules_select = response.data;
    });
  },

  methods: {
    loadData() {
      if (this.id > 0) {
        axios.get("/api/events/races/" + this.id).then(response => {
          this.races = response.data;
        });
        this.event = parseInt(this.id);
      }
      this.defaultForm = {
        name: "",
        race_number: "",
        gender: "PA",
        style: "",
        distance: "",
        rules: []
      };
      this.form = this.defaultForm;

      axios.get("/api/events/races/available/" + this.id).then(response => {
        this.races_select = response.data;
        this.race_selected = this.races_select[0];
      });
    },
    deleteData(id) {
      // delete data
      if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
        axios.delete("/api/events/races/" + id).then(response => {
          this.loadData();
        });
      }
    },
    editData(item) {
      // delete data
      this.form = Object.assign({}, item);
      this.race_selected = item.pure_races;
      this.edit = true;
      this.dialog = true;
    },
    createData() {
      // delete data
      this.edit = false;
      this.dialog = true;
    },
    save() {
      this.formHasErrors = false;
      this.form.event_id = this.id;
      this.form.pure_race = this.race_selected.id;
      Object.keys(this.formtest).forEach(f => {
        if (!this.formtest[f]) this.formHasErrors = true;

        this.$refs[f].validate(true);
      });
      if (!this.formHasErrors && this.file_error_messages == null) {
        if (this.edit && this.form.id > 0) {
          this.isLoading = true;
          axios
            .post("/api/events/races/" + this.form.id, {
              data: this.form,
              _method: "patch"
            })

            .then(response => {
              // push router ke read data
              this.loadData();
              this.isLoading = false;
              this.close();
            })
            .catch(errors => {
              this.isLoading = false;
              this.formerrors.race_number =
                errors.response.data.errors.race_number;
            });
        } else {
          this.isLoading = true;
          axios
            .post("/api/events/races/", this.form)
            .then(response => {
              // push router ke read data

              this.loadData();
              this.isLoading = false;
              this.close();
            })
            .catch(errors => {
              this.isLoading = false;
              this.formerrors.race_number =
                errors.response.data.errors.race_number;
            });
        }
      }
    },
    close() {
      this.disablewatch = false;
      this.dialog = false;
      this.formerrors.race_number = "";
      setTimeout(() => {
        this.form = this.defaultForm;
        this.edit = false;
      }, 300);
    }
  },
  watch: {
    dialog(val) {
      val || this.close();
    },
    event(val) {
      this.id = val;
      this.loadData();
    },
    race_selected(val) {
      this.form.style = val.style;
      this.form.distance = val.distance;
      var races = val.races;
      let gender_picked = races.map(r => r.gender);
      let g = [{ text: "PA" }, { text: "PI" }];
      this.genders = g.filter(function(el) {
        return gender_picked.indexOf(el.text) < 0;
      });
    }
  }
};
</script>