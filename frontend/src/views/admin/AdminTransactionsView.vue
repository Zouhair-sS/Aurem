<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import api from '@/services/api'

const transactions = ref([])
const loading = ref(true)
const pagination = ref({ current: 1, last: 1 })

const filterType = ref('')
const filterCategory = ref('')
const filterMonth = ref('')
const filterYear = ref('')

const typeDropdownOpen = ref(false)

const typeOptions = [
  { value: '', label: 'Tous les types', icon: '⊘' },
  { value: 'income', label: 'Revenus', icon: '↗' },
  { value: 'expense', label: 'Dépenses', icon: '↙' },
]

const selectedTypeLabel = computed(() => {
  const found = typeOptions.find(o => o.value === filterType.value)
  return found ? found.label : 'Tous les types'
})

const selectedTypeIcon = computed(() => {
  const found = typeOptions.find(o => o.value === filterType.value)
  return found ? found.icon : '⊘'
})

const selectType = (value) => {
  filterType.value = value
  typeDropdownOpen.value = false
}

const months = [
  { value: '', label: 'Tous les mois' },
  { value: '1', label: 'Janvier' },
  { value: '2', label: 'Février' },
  { value: '3', label: 'Mars' },
  { value: '4', label: 'Avril' },
  { value: '5', label: 'Mai' },
  { value: '6', label: 'Juin' },
  { value: '7', label: 'Juillet' },
  { value: '8', label: 'Août' },
  { value: '9', label: 'Septembre' },
  { value: '10', label: 'Octobre' },
  { value: '11', label: 'Novembre' },
  { value: '12', label: 'Décembre' },
]

const currentYear = new Date().getFullYear()
const years = computed(() => {
  const list = [{ value: '', label: 'Toutes les années' }]
  for (let y = currentYear; y >= currentYear - 5; y--) {
    list.push({ value: String(y), label: String(y) })
  }
  return list
})

const clearFilters = () => {
  filterType.value = ''
  filterCategory.value = ''
  filterMonth.value = ''
  filterYear.value = ''
}

const hasActiveFilters = computed(() => {
  return filterType.value || filterCategory.value || filterMonth.value || filterYear.value
})

const fetchTransactions = async (page = 1) => {
  loading.value = true
  try {
    let url = `/admin/transactions?page=${page}`
    if (filterType.value) url += `&type=${filterType.value}`
    if (filterCategory.value) url += `&category=${filterCategory.value}`
    if (filterMonth.value) url += `&month=${filterMonth.value}`
    if (filterYear.value) url += `&year=${filterYear.value}`
    
    const { data } = await api.get(url)
    transactions.value = data.data
    pagination.value = { current: data.current_page, last: data.last_page }
  } catch (err) {
    console.error(err)
  } finally {
    loading.value = false
  }
}

watch([filterType, filterCategory, filterMonth, filterYear], () => {
  fetchTransactions(1)
})

onMounted(() => fetchTransactions())

const closeDropdown = (e) => {
  if (!e.target.closest('.custom-dropdown')) {
    typeDropdownOpen.value = false
  }
}

const formatDate = (raw) => {
  if (!raw) return ''
  const d = new Date(raw)
  if (isNaN(d)) return raw
  const dd = String(d.getDate()).padStart(2, '0')
  const mm = String(d.getMonth() + 1).padStart(2, '0')
  const yyyy = d.getFullYear()
  const hh = String(d.getHours()).padStart(2, '0')
  const min = String(d.getMinutes()).padStart(2, '0')
  return `${dd}/${mm}/${yyyy} à ${hh}:${min}`
}
</script>

<template>
  <div class="admin-transactions" @click="closeDropdown">
    <div class="page-header">
      <h1 class="page-title">Transactions (Global Feed)</h1>
    </div>

    <div class="filters-bar">
      <div class="filters-row">
        <!-- Custom Type Dropdown -->
        <div class="custom-dropdown" :class="{ open: typeDropdownOpen }">
          <button class="dropdown-trigger" @click.stop="typeDropdownOpen = !typeDropdownOpen">
            <span class="dropdown-icon">{{ selectedTypeIcon }}</span>
            <span class="dropdown-label">{{ selectedTypeLabel }}</span>
            <svg class="dropdown-chevron" :class="{ rotated: typeDropdownOpen }" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
          </button>
          <transition name="dropdown-fade">
            <div class="dropdown-menu" v-if="typeDropdownOpen">
              <button 
                v-for="opt in typeOptions" 
                :key="opt.value" 
                class="dropdown-item"
                :class="{ selected: filterType === opt.value }"
                @click.stop="selectType(opt.value)"
              >
                <span class="item-icon">{{ opt.icon }}</span>
                <span class="item-label">{{ opt.label }}</span>
                <svg v-if="filterType === opt.value" class="check-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
              </button>
            </div>
          </transition>
        </div>

        <!-- Category Input -->
        <div class="filter-field">
          <svg class="field-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          <input v-model="filterCategory" type="text" placeholder="Catégorie..." class="filter-input" />
        </div>

        <!-- Month Selector -->
        <div class="filter-field select-field">
          <svg class="field-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          <select v-model="filterMonth" class="filter-select">
            <option v-for="m in months" :key="m.value" :value="m.value">{{ m.label }}</option>
          </select>
        </div>

        <!-- Year Selector -->
        <div class="filter-field select-field">
          <svg class="field-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          <select v-model="filterYear" class="filter-select">
            <option v-for="y in years" :key="y.value" :value="y.value">{{ y.label }}</option>
          </select>
        </div>

        <!-- Clear Filters -->
        <transition name="btn-fade">
          <button v-if="hasActiveFilters" class="clear-btn" @click="clearFilters">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            Effacer
          </button>
        </transition>
      </div>
    </div>

    <div class="table-card">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Utilisateur</th>
            <th>Type</th>
            <th>Catégorie</th>
            <th>Description</th>
            <th class="text-right">Montant</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="loading"><td colspan="6" class="text-center">Chargement...</td></tr>
          <tr v-else-if="transactions.length === 0"><td colspan="6" class="text-center">Aucune transaction trouvée.</td></tr>
          <tr v-for="tx in transactions" :key="tx.id + tx.type" class="table-row">
            <td>{{ formatDate(tx.date) }}</td>
            <td>
              <div class="user-info">
                <strong>{{ tx.user_name }}</strong>
                <span class="text-muted">{{ tx.user_email }}</span>
              </div>
            </td>
            <td>
              <span class="badge" :class="tx.type === 'income' ? 'badge-income' : 'badge-expense'">
                {{ tx.type === 'income' ? 'Revenu' : 'Dépense' }}
              </span>
            </td>
            <td>{{ tx.category_name }}</td>
            <td>{{ tx.description }}</td>
            <td class="text-right font-bold" :class="tx.type === 'income' ? 'text-green' : 'text-red'">
              {{ tx.type === 'income' ? '+' : '-' }}{{ Number(tx.amount).toLocaleString('fr-MA', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }} dh
            </td>
          </tr>
        </tbody>
      </table>

      <div class="pagination" v-if="pagination.last > 1">
        <button 
          class="page-btn"
          :disabled="pagination.current === 1" 
          @click="fetchTransactions(pagination.current - 1)"
        >
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
          <span>Précédent</span>
        </button>
        <div class="page-info">
          <span class="page-current">{{ pagination.current }}</span>
          <span class="page-sep">sur</span>
          <span class="page-total">{{ pagination.last }}</span>
        </div>
        <button 
          class="page-btn"
          :disabled="pagination.current === pagination.last" 
          @click="fetchTransactions(pagination.current + 1)"
        >
          <span>Suivant</span>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.page-title { font-family: 'Playfair Display', serif; font-size: 2rem; color: #111827; }

/* ── Filters Bar ── */
.filters-bar {
  background: white;
  border-radius: 14px;
  padding: 16px 20px;
  margin-bottom: 20px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
  border: 1px solid #e5e7eb;
}

.filters-row {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
}

/* ── Custom Dropdown ── */
.custom-dropdown {
  position: relative;
}

.dropdown-trigger {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 10px 14px;
  background: #f9fafb;
  border: 1.5px solid #e5e7eb;
  border-radius: 10px;
  cursor: pointer;
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
  transition: all 0.2s ease;
  min-width: 170px;
}

.dropdown-trigger:hover {
  border-color: #c9a84c;
  background: #fffbf0;
}

.custom-dropdown.open .dropdown-trigger {
  border-color: #c9a84c;
  box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.12);
  background: #fffbf0;
}

.dropdown-icon {
  font-size: 1rem;
}

.dropdown-label {
  flex: 1;
  text-align: left;
}

.dropdown-chevron {
  transition: transform 0.25s ease;
  color: #9ca3af;
}

.dropdown-chevron.rotated {
  transform: rotate(180deg);
}

.dropdown-menu {
  position: absolute;
  top: calc(100% + 6px);
  left: 0;
  min-width: 100%;
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12), 0 4px 8px rgba(0, 0, 0, 0.04);
  padding: 6px;
  z-index: 50;
  overflow: hidden;
}

.dropdown-item {
  display: flex;
  align-items: center;
  gap: 10px;
  width: 100%;
  padding: 10px 12px;
  border: none;
  background: transparent;
  cursor: pointer;
  font-size: 0.875rem;
  color: #374151;
  border-radius: 8px;
  transition: all 0.15s ease;
}

.dropdown-item:hover {
  background: #f5f3ef;
}

.dropdown-item.selected {
  background: #fffbf0;
  color: #92700c;
  font-weight: 600;
}

.item-icon {
  font-size: 1rem;
  width: 20px;
  text-align: center;
}

.item-label {
  flex: 1;
  text-align: left;
}

.check-icon {
  color: #c9a84c;
}

/* ── Dropdown Transition ── */
.dropdown-fade-enter-active {
  transition: all 0.2s ease;
}
.dropdown-fade-leave-active {
  transition: all 0.15s ease;
}
.dropdown-fade-enter-from {
  opacity: 0;
  transform: translateY(-6px) scale(0.97);
}
.dropdown-fade-leave-to {
  opacity: 0;
  transform: translateY(-4px) scale(0.98);
}

/* ── Filter Fields ── */
.filter-field {
  position: relative;
  display: flex;
  align-items: center;
}

.field-icon {
  position: absolute;
  left: 12px;
  color: #9ca3af;
  pointer-events: none;
  z-index: 1;
}

.filter-input {
  padding: 10px 12px 10px 36px;
  border: 1.5px solid #e5e7eb;
  border-radius: 10px;
  outline: none;
  font-size: 0.875rem;
  color: #374151;
  background: #f9fafb;
  transition: all 0.2s ease;
  width: 160px;
}

.filter-input:focus {
  border-color: #c9a84c;
  background: #fffbf0;
  box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.12);
}

.filter-input::placeholder {
  color: #9ca3af;
}

.select-field {
  position: relative;
}

.filter-select {
  padding: 10px 32px 10px 36px;
  border: 1.5px solid #e5e7eb;
  border-radius: 10px;
  outline: none;
  font-size: 0.875rem;
  color: #374151;
  background: #f9fafb;
  cursor: pointer;
  transition: all 0.2s ease;
  appearance: none;
  -webkit-appearance: none;
  background-image: url("data:image/svg+xml,%3csvg width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2' xmlns='http://www.w3.org/2000/svg'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
  background-repeat: no-repeat;
  background-position: right 10px center;
  min-width: 160px;
}

.filter-select:hover {
  border-color: #c9a84c;
  background-color: #fffbf0;
}

.filter-select:focus {
  border-color: #c9a84c;
  background-color: #fffbf0;
  box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.12);
}

/* ── Clear Button ── */
.clear-btn {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 10px 16px;
  border: 1.5px solid #fee2e2;
  background: #fef2f2;
  color: #dc2626;
  border-radius: 10px;
  cursor: pointer;
  font-size: 0.825rem;
  font-weight: 500;
  transition: all 0.2s ease;
}

.clear-btn:hover {
  background: #fee2e2;
  border-color: #fca5a5;
}

.btn-fade-enter-active, .btn-fade-leave-active {
  transition: all 0.2s ease;
}
.btn-fade-enter-from, .btn-fade-leave-to {
  opacity: 0;
  transform: scale(0.9);
}

/* ── Table ── */
.table-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
  border: 1px solid #e5e7eb;
  overflow: hidden;
}

.admin-table { width: 100%; border-collapse: collapse; }
.admin-table th, .admin-table td { padding: 16px 24px; text-align: left; border-bottom: 1px solid #e5e7eb; }
.admin-table th { background: #f9fafb; color: #6b7280; font-size: 0.75rem; text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em; }
.admin-table td { font-size: 0.95rem; color: #374151; }

.table-row {
  transition: background 0.15s ease;
}
.table-row:hover {
  background: #fafaf8;
}

.user-info { display: flex; flex-direction: column; }
.text-muted { font-size: 0.8rem; color: #6b7280; }

.badge { padding: 4px 10px; border-radius: 999px; font-size: 0.75rem; font-weight: 600; }
.badge-income { background: #dcfce7; color: #166534; }
.badge-expense { background: #fee2e2; color: #991b1b; }

.text-right { text-align: right; }
.text-center { text-align: center; }
.font-bold { font-weight: 600; }
.text-green { color: #10b981; }
.text-red { color: #dc2626; }

/* ── Pagination ── */
.pagination {
  padding: 16px 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-top: 1px solid #e5e7eb;
  background: #f9fafb;
}

.page-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 9px 18px;
  border: 1.5px solid #e5e7eb;
  background: white;
  border-radius: 10px;
  cursor: pointer;
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
}

.page-btn:hover:not(:disabled) {
  border-color: #c9a84c;
  color: #92700c;
  background: #fffbf0;
  box-shadow: 0 2px 8px rgba(201, 168, 76, 0.15);
  transform: translateY(-1px);
}

.page-btn:active:not(:disabled) {
  transform: translateY(0);
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
}

.page-btn:disabled {
  opacity: 0.4;
  cursor: not-allowed;
  background: #f3f4f6;
}

.page-btn svg {
  transition: transform 0.2s ease;
}

.page-btn:hover:not(:disabled) svg {
  transform: translateX(-2px);
}

.page-btn:last-child:hover:not(:disabled) svg {
  transform: translateX(2px);
}

.page-info {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 0.875rem;
  color: #6b7280;
}

.page-current {
  background: #111827;
  color: white;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.85rem;
}

.page-sep {
  color: #9ca3af;
}

.page-total {
  font-weight: 500;
  color: #374151;
}
</style>
