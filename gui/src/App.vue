<template>
  <div id="app" class="container-fluid d-flex my-5 align-items-center flex-column">
    <h1>Country search</h1>
    <p v-if="sort.length">Current sort: {{ sort }} {{ sortDesc ? 'DESC' : 'ASC' }}</p>
    <div class="search-container mt-4">
      <input type="text" class="form-control" placeholder="Start typing..."
             v-debounce:300ms="fetchCountries" v-model="query">
    </div>
    <div class="result-container mt-4 d-flex flex-column">
      <div v-if="isLoading" class="spinner-border mx-auto"></div>
      <table v-else class="table">
        <thead>
        <tr>
          <th>Flag</th>
          <th>
            <a href="#" @click="toggleSort('sName')">Name</a>
          </th>
          <th>
            <a href="#" @click="toggleSort('sISOCode')">ISO Code</a>
          </th>
          <th>
            <a href="#" @click="toggleSort('sCapitalCity')">Capital City</a>
          </th>
          <th>
            <a href="#" @click="toggleSort('sContinentCode')">Continent</a>
          </th>
          <th>
            <a href="#" @click="toggleSort('sCurrencyISOCode')">Currency</a>
          </th>
          <th>
            Languages
          </th>
        </tr>
        </thead>
        <tbody v-if="countries.length">
        <tr v-for="country in sortedCountries" :key="country.sISOCode">
          <td><img :src="country.sCountryFlag" :alt="country.sISOCode" width="20" height="10"></td>
          <td>{{ country.sName }}</td>
          <td>{{ country.sISOCode }}</td>
          <td>{{ country.sCapitalCity }}</td>
          <td>{{ country.sContinentCode }}</td>
          <td>{{ country.sCurrencyISOCode }}</td>
          <td>{{ getLanguages(country) }}</td>
        </tr>
        </tbody>
        <tbody v-else>
        <tr>
          <td colspan="7" class="text-center">Nothing here</td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios';


export default {
  name: 'App',
  data() {
    return {
      isLoading: false,
      query: '',
      countries: [],
      sort: '',
      sortDesc: false
    }
  },
  mounted() {
    this.fetchCountries();
  },
  methods: {
    fetchCountries() {
      this.isLoading = true;
      axios.get('http://localhost:5000/countries', {
        params: {q: this.query}
      }).then((r) => {
        this.countries = r.data.countries
      }).finally(() => {
        this.isLoading = false;
      });
    },
    getLanguages(country) {
      if (!country.Languages.tLanguage) {
        return '-';
      }

      if (!Array.isArray(country.Languages.tLanguage)) {
        return country.Languages.tLanguage.sName;
      }

      return country.Languages.tLanguage.map((i) => i.sName).join(', ');
    },
    toggleSort(col) {
      if (!this.sort.length || this.sort !== col) {
        this.sort = col;
        this.sortDesc = false;
      } else {
        this.sortDesc = !this.sortDesc;

      }
    },
  },
  computed: {
    sortedCountries() {
      if (!this.sort.length) {
        return this.countries;
      }

      let countriesToSort = JSON.parse(JSON.stringify(this.countries));

      return countriesToSort.sort((a, b) => {
        if (a[this.sort] < b[this.sort] ){
          return this.sortDesc ? 1 : -1;
        }
        if (a[this.sort] > b[this.sort]){
          return this.sortDesc ? -1 : 1;
        }
        return 0;
      });
    },
  },
}
</script>

<style>
html, body, #app, .result-container {
  height: 100%;
  width: 100%;
}
</style>
