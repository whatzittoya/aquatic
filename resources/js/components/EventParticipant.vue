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
                                    <v-btn color="primary" dark class="mb-2" v-on="on">Tambah Peserta</v-btn>
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
                                 <v-select v-model="form.member" :items="form.club.members"
                                                            item-text="name" item-value="id" label="Member"
                                                           return-object="" ></v-select>
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
                                 <v-select v-model="form.race" :items="races"
                                                            item-text="pure_races.name" item-value="id" label="Lomba" return-object=""
                                                            ></v-select>
                                                    </v-col> 
                                                      <v-col cols="12" sm="12" md="6">
                                                        <v-text-field v-model="form.rule"
                                                            label="Kategori" disabled="">
                                                        </v-text-field>
                                                    </v-col>  
                                                    
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-select v-model="form.valid_payment" :items="payment" label="Pembayaran"></v-select>
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
            {{ timeFormat(item.best_time) }}
          </template>
                    <template v-slot:item.action="{ item }">
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
    </div>
</template>

<!-- script js -->
<script>
export default {
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

      var milisecond =
        +time[0] * 60 * 60 * 1000 +
        +time[1] * 60 * 1000 +
        +second[0] * 1000 +
        second[1] * 1;
      return milisecond;
    }
  },

  data() {
    return {
      id: "",
      event_name: "",
      participants: [],
      headers: [
        { text: "Klub", value: "club.name" },
        { text: "Nama", value: "member.name" },
        { text: "Lomba", value: "race.pure_races.name" },
        { text: "Kategori", value: "rule.name" },
        { text: "Best Time", value: "best_time" },
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

      ruletext: ""
    };
  },
  created() {
    this.id = this.$route.params.id;
    this.loadData();
  },

  methods: {
    loadData() {
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

      axios.get("/api/events").then(response => {
        this.events = response.data;
        var id = this.id;
        var selected_event = this.events.filter(function(event) {
          return event.id == id;
        });
        this.form.event = selected_event[0].name;
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
      this.form = Object.assign({}, item);
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
      if (!this.formHasErrors && this.file_error_messages == null) {
        if (this.edit && this.form.id > 0) {
          axios
            .post("/api/events/participants/" + this.form.id, {
              data: this.form,
              _method: "patch"
            })

            .then(response => {
              // push router ke read data
              this.loadData();
              this.close();
            })
            .catch(errors => {});
        } else {
          axios
            .post("/api/events/participants/", this.form)
            .then(response => {
              // push router ke read data

              this.loadData();
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
    "form.member"(val) {
      this.born_date = val.born_date;
      this.gender = val.gender;
      axios
        .get("/api/events/participants/races/" + this.id + "/" + val.id)
        .then(response => {
          this.races = response.data;
          this.form.race = this.races[0];
        });
    },
    "form.race"(val) {
      var rules = val.rules;
      var age = this.age;
      var rule = val.rules.filter(function(rule) {
        return rule.min_age <= age && rule.max_age >= age;
      });
      this.form.rule = rule[0].name;
      this.form.rule_id = rule[0].id;
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