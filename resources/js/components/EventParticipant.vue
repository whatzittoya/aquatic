<template>
    <div>

        <div class="row">

            <div class="col-md-12">
                <v-card-title>
                    Lomba Event
                    <v-spacer></v-spacer>
                </v-card-title>
                <v-data-table :headers="headers" :items="participants" class="elevation-1" :search="search">
                    <template v-slot:top>
                        <v-toolbar flat color="white">
                            <!-- <v-select v-model="event" :items="events" item-text="name" item-value="id"
                                label="event" ></v-select> -->
                     <v-select v-model="event" :items="events"
                                                            item-text="name" item-value="id" label="Pilih Event" return-object=""
                                                      ></v-select>

                            <v-spacer></v-spacer>
                            <v-dialog v-model="dialog" max-width="500px">
                                <template v-slot:activator="{ on }">
                                    <v-btn color="primary" dark class="mb-2" v-on="on" :disabled="id=='all' || locked">Tambah Peserta</v-btn>
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
                                 <v-select v-model="form.club" :items="clubs"
                                                            item-text="name" item-value="id" label="Klub"
                                                           return-object ></v-select>
                                                    </v-col>
                                                   
                                             <v-col cols="12" sm="12" md="6">
                                 <v-select v-model="form.member" :items="members"
                                                            item-text="name" item-value="id" label="Member"
                                                           return-object="" ></v-select>
                                                    </v-col>  
                                                    <v-col cols="12" sm="12" md="6">
                                 <v-select v-model="form.race" :items="races"
                                                            item-text="pure_races.name" item-value="id" label="Lomba" return-object=""
                                                            ></v-select>
                                                    </v-col> 
                                                      <v-col cols="12" sm="12" md="6">
                                                        <v-text-field v-model="gender" label="Gender" disabled=""
                                                            >
                                                        </v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-text-field v-model="age"
                                                            label="Umur" disabled="" >
                                                        </v-text-field>
                                                    </v-col>    
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-text-field v-model="form.old_event" label="Event Terakhir"
                                                            >
                                                        </v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-text-field v-model="form.old_race"
                                                            label="Lomba Terakhir" >
                                                        </v-text-field>
                                                    </v-col>
                                                      <v-col cols="12" sm="12" md="6">
                                                        <v-text-field v-model="form.old_best_time"
                                                            label="Best Time Terakhir" type="time"  step="0.001" >
                                                        </v-text-field>
                                                    </v-col>
                                                      <v-col cols="12" sm="12" md="6">
                                                        <v-text-field v-model="form.event"
                                                            label="Event" disabled="">
                                                        </v-text-field>
                                                    </v-col>
                                                      
                                                      <v-col cols="12" sm="12" md="6">
                                                        <v-text-field v-model="form.rule"
                                                            label="Kategori" disabled="">
                                                        </v-text-field>
                                                    </v-col>  
                                                    
                                                 
                       
                        <v-col cols="12" sm="12" md="6" >
                          <b>Validasi Pembayaran :</b>
                          <div v-if="form.valid_payment">
                              <v-chip class="ma-2" color="green" text-color="white" label> Valid </v-chip>
                          </div>
                          <div v-else>
                            <v-chip class="ma-2" color="red" text-color="white" label> Tidak Valid </v-chip>
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
                     <template v-slot:item.best_time="{ item }">
            {{ item.best_time}}
          </template>
          <template v-slot:item.valid_payment="{ item }">
              {{item.valid_payment==1?'Valid':'Tidak Valid'}}
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
    age() {
      var today = new Date();
      var birthDate = new Date(this.born_date);
      var m = today.getMonth() - birthDate.getMonth();
      var age = today.getFullYear() - birthDate.getFullYear();
      if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age = age - 1;
      }
      return age;
    },
    timeToInt: function() {
      // `this` points to the vm instance
      let time = this.form.old_best_time.split(":");
      if (time.length < 3) {
        time.unshift(0);
      }

      let second = time[2].split(".");

      var ms = 0;
      if (second.length == 1) {
        ms = 0;
      } else if (second.length > 1) {
        ms = second[1];
      }
      var milisecond =
        +time[0] * 60 * 60 * 1000 +
        +time[1] * 60 * 1000 +
        +second[0] * 1000 +
        ms * 1;
    },
    locked() {
      var id = this.event;
      try {
        let e = this.events.filter(function(event) {
          return event.id == id;
        });

        return e[0].lock != 1 ? false : true;
      } catch (error) {
        return 1;
      }
    }
  },

  data() {
    return {
      isLoading: false,
      fullPage: true,
      id: "",
      event_name: "",
      participants: [],
      headers: [
        { text: "Klub", value: "club.name" },
        { text: "Nama", value: "member.name" },
        { text: "Gender", value: "member.gender" },
        { text: "Lomba", value: "race.pure_races.name" },
        { text: "Kategori", value: "rule.name" },
        { text: "Best Time", value: "best_time" },
        { text: "Pembayaran", value: "valid_payment" },
        { text: "Aksi", value: "action", sortable: false }
      ],

      races_form: {
        required: value => !!value || "Required."
      },

      edit: false,

      showModal: false,

      events: [],
      event: "",
      races: [],
      clubs: [],
      members: [],
      race_selected: [],
      payment: [
        { text: "Tidak Valid", value: 0 },
        { text: "Valid", value: 1 }
      ],

      form: {},
      born_date: "",
      gender: "",
      defaultForm: {},
      formerrors: {
        race_number: "",
        name: ""
      },
      search: "",
      dialog: false,
      formHasErrors: false,
      role: "",
      ruletext: ""
    };
  },
  created() {
    this.id = this.$route.params.id;
    this.loadData();
  },

  methods: {
    loadData() {
      axios.get("/api/role").then(response => {
        // mengirim data hasil fetch ke varibale array persons
        this.role = response.data.name;
        // console.log(response.data);
      });
      this.defaultForm = {
        old_event: "",
        old_race: "",
        old_best_time: "00:59:59.999",
        club: "",
        member: "",
        race: "",
        event: this.event_name,
        rule: "",
        best_time: "",
        valid_payment: 0
      };
      this.form = this.defaultForm;
      if (this.id > 0) {
        axios.get("/api/events/participants/" + this.id).then(response => {
          this.participants = response.data;
        });
        this.event = parseInt(this.id);
      }
      axios
        .get("/api/events/participants/members/" + this.id)
        .then(response => {
          this.clubs = response.data;
        });

      axios.get("/api/events/showcurrent").then(response => {
        this.events = response.data;
        if (this.id > 0) {
          var id = this.id;
          var selected_event = this.events.filter(function(event) {
            return event.id == id;
          });
          this.form.event = selected_event[0].name;
        }
      });
    },
    deleteData(id) {
      // delete data
      if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
        axios.delete("/api/events/participants/" + id).then(response => {
          this.loadData();
        });
      }
    },
    editData(item) {
      // delete data
      this.form.id = item.id;
      this.form.club = item.club;
      this.form.member = item.member;
      this.form.gender = item.member.gender;
      this.born_date = item.member.born_date;
      this.form.age = this.age;
      this.form.old_event = item.old_event;
      this.form.old_race = item.old_race;
      this.form.old_best_time = this.timeFormat(item.old_best_time);
      this.form.race = item.race;
      this.form.valid_payment = item.valid_payment;

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
      this.form.o_best_time = this.timeToInt;
      //   Object.keys(this.formtest).forEach(f => {
      //     if (!this.formtest[f]) this.formHasErrors = true;

      //     this.$refs[f].validate(true);
      //   });
      if (!this.formHasErrors) {
        if (this.edit && this.form.id > 0) {
          this.isLoading = true;
          axios
            .post("/api/events/participants/" + this.form.id, {
              data: this.form,
              _method: "patch"
            })

            .then(response => {
              // push router ke read data
              this.loadData();
              this.isLoading = false;
              this.close();
            })
            .catch(errors => {});
        } else {
          this.isLoading = true;
          axios
            .post("/api/events/participants/", this.form)
            .then(response => {
              // push router ke read data

              this.loadData();
              this.isLoading = false;
              this.close();
            })
            .catch(errors => {});
        }
      }
    },
    close() {
      this.disablewatch = false;
      this.dialog = false;
      setTimeout(() => {
        this.form = this.defaultForm;
        this.edit = false;
      }, 300);
    },
    timeFormat(milisecond) {
      let hour = 0;
      let minute = 0;
      let second = 0;
      let mili = 0;

      hour = Math.floor(milisecond / 3600000);

      if (hour.toString.length < 2) {
        hour = ("0" + hour).slice(-2);
      }
      milisecond = milisecond - hour * 3600000;

      minute = Math.floor(milisecond / 60000);
      minute = ("0" + minute).slice(-2);
      milisecond = milisecond - minute * 60000;
      second = Math.floor(milisecond / 1000);
      second = ("0" + second).slice(-2);
      milisecond = milisecond - second * 1000;
      mili = milisecond;
      mili = ("00" + mili).slice(-3);

      return hour + ":" + minute + ":" + second + "." + mili;
    }
  },
  watch: {
    dialog(val) {
      val || this.close();
    },
    "form.club"(val) {
      if (this.id > 0) {
        var id = this.id;
        axios
          .get("/api/events/participants/members/" + id + "/" + val.id)
          .then(response => {
            this.members = response.data;
            if (!this.edit) {
              this.form.member = this.members[0];
            }
          });
      }
    },
    "form.member"(val) {
      if (this.id > 0 && val) {
        this.born_date = val.born_date;
        this.gender = val.gender;
        var id = this.id;
        if (!this.edit) {
          axios
            .get("/api/events/participants/races/" + id + "/" + val.id)
            .then(response => {
              this.races = response.data;

              this.form.race = this.races[0];
            });
        } else {
          axios
            .get(
              "/api/events/participants/races/" +
                id +
                "/" +
                val.id +
                "/" +
                this.form.id
            )
            .then(response => {
              this.races = response.data;
            });
        }
      }
    },
    "form.race"(val) {
      console.log(val);
      try {
        var rules = val.rules;
        var age = this.age;

        var rule = val.rules.filter(function(rule) {
          return rule.min_age <= age && rule.max_age >= age;
        });
        this.form.rule = rule[0].name;
        this.form.rule_id = rule[0].id;

        axios
          .get(
            "/api/events/participants/lastrecord/" +
              this.form.member.id +
              "/" +
              this.form.race.pure_race_id
          )
          .then(response => {
            let res = response.data;
            if (res.length > 0) {
              this.form.old_event = res[0].old_event;
              this.form.old_race = res[0].old_race;
              this.form.old_best_time = this.timeFormat(res[0].old_best_time);
            } else {
              this.form.old_event = "";
              this.form.old_race = "";
              this.form.old_best_time = "00:59:59.999";
            }
          });
      } catch (error) {}
    },
    event(val) {
      if (val.id > 0) {
        this.id = val.id;

        this.event_name = val.name;

        this.loadData();
      }
    }
  }
};
</script>