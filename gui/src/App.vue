<template>
  <div id="app" class="container-fluid d-flex my-5 align-items-center flex-column">
    <h1>Country search</h1>
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
          <th>Name</th>
          <th>ISO Code</th>
          <th>Capital City</th>
          <th>Continent</th>
          <th>Currency</th>
          <th>Languages</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="country in countries" :key="country.sISOCode">
          <td><img :src="country.sCountryFlag" :alt="country.sISOCode" width="20" height="10"></td>
          <td>{{ country.sName }}</td>
          <td>{{ country.sISOCode }}</td>
          <td>{{ country.sCapitalCity }}</td>
          <td>{{ country.sContinentCode }}</td>
          <td>{{ country.sCurrencyISOCode }}</td>
          <td>{{ getLanguages(country) }}</td>
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
    }
  },
}
</script>

<style>
html, body, #app {
  height: 100%;
}
</style>
