<script setup>
import { computed, onMounted, ref, watch } from 'vue'
import { useI18n } from 'vue-i18n'
import api from '../services/api'

const { t, locale } = useI18n()
const categories = ref([])
const expenses = ref([])
const limits = ref({})
const saved = ref(false)
const loading = ref(false)

const now = new Date()
const selectedMonth = ref(now.getMonth() + 1)
const selectedYear = ref(now.getFullYear())

const monthNames = [
  'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
  'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre',
]

const currentYear = now.getFullYear()
const years = computed(() => {
  const list = []
  for (let y = currentYear; y >= currentYear - 4; y--) list.push(y)
  return list
})

const monthKey = computed(() => `${selectedYear.value}-${String(selectedMonth.value).padStart(2, '0')}`)
const storageKey = computed(() => `budgetwise_limits_${monthKey.value}`)

const displayLabel = computed(() => `${monthNames[selectedMonth.value - 1]} ${selectedYear.value}`)

const currency = (value) => {
  const num = Number(value ?? 0)
  return `${new Intl.NumberFormat('fr-MA', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(num)} dh`
}

const spentByCategory = computed(() => {
  const grouped = {}
  for (const expense of expenses.value) {
    const catId = expense.category_id
    const catName = expense.category?.name
    grouped[catId] = (grouped[catId] || 0) + Number(expense.amount || 0)
    if (catName) {
      grouped[`name:${catName}`] = (grouped[`name:${catName}`] || 0) + Number(expense.amount || 0)
    }
  }
  return grouped
})

const totalBudget = computed(() => Object.values(limits.value).reduce((s, v) => s + Number(v || 0), 0))
const totalSpent = computed(() => {
  return Object.entries(spentByCategory.value)
    .filter(([key]) => !key.startsWith('name:'))
    .reduce((s, [, v]) => s + v, 0)
})
const totalRemaining = computed(() => totalBudget.value - totalSpent.value)

const budgetRows = computed(() => {
  return categories.value
    .filter((category) => category.type === 'expense' || category.type === 'both')
    .map((category) => {
      const byId = spentByCategory.value[category.id] || 0
      const byName = spentByCategory.value[`name:${category.name}`] || 0
      const spent = Math.max(byId, byName)
      const limit = Number(limits.value[category.id] || 0)
      const remaining = limit - spent
      const progress = limit > 0 ? Math.min((spent / limit) * 100, 100) : 0
      return { ...category, spent, limit, remaining, progress }
    })
})

const loadExpenses = async () => {
  loading.value = true
  try {
    const res = await api.get(`/expenses?month=${selectedMonth.value}&year=${selectedYear.value}`)
    expenses.value = res.data
  } finally {
    loading.value = false
  }
}

const loadLimits = () => {
  const stored = localStorage.getItem(storageKey.value)
  limits.value = stored ? JSON.parse(stored) : {}
}

const loadData = async () => {
  const categoryRes = await api.get('/categories')
  categories.value = categoryRes.data
  loadLimits()
  await loadExpenses()
}

watch([selectedMonth, selectedYear], async () => {
  loadLimits()
  await loadExpenses()
})

const saveBudgets = () => {
  localStorage.setItem(storageKey.value, JSON.stringify(limits.value))
  saved.value = true
  window.setTimeout(() => { saved.value = false }, 1800)
}

onMounted(loadData)
</script>

<template>
  <div class="budgets-view">
    <header class="top-bar content-appear">
      <h1>{{ t('budgets') }}</h1>
      <p class="subtitle">{{ t('budgetsSubtitle') }}</p>
    </header>

    <!-- Month picker -->
    <div class="month-picker-card content-appear content-appear-delay-1">
      <div class="picker-label">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
        <span>Période analysée :</span>
        <strong>{{ displayLabel }}</strong>
      </div>
      <div class="picker-controls">
        <select v-model.number="selectedMonth" class="picker-select">
          <option v-for="(name, i) in monthNames" :key="i + 1" :value="i + 1">{{ name }}</option>
        </select>
        <select v-model.number="selectedYear" class="picker-select">
          <option v-for="y in years" :key="y" :value="y">{{ y }}</option>
        </select>
      </div>
    </div>

    <!-- Summary strip -->
    <div class="summary-strip content-appear content-appear-delay-2" v-if="totalBudget > 0">
      <div class="summary-item">
        <span class="summary-label">Budget total</span>
        <span class="summary-value">{{ currency(totalBudget) }}</span>
      </div>
      <div class="summary-divider"></div>
      <div class="summary-item">
        <span class="summary-label">Dépensé</span>
        <span class="summary-value spent">{{ currency(totalSpent) }}</span>
      </div>
      <div class="summary-divider"></div>
      <div class="summary-item">
        <span class="summary-label">Restant</span>
        <span class="summary-value" :class="totalRemaining < 0 ? 'over' : 'safe'">{{ currency(totalRemaining) }}</span>
      </div>
    </div>

    <div class="card content-appear content-appear-delay-3">
      <div class="card-header">
        <h2>{{ t('monthlyBudgetPlanner') }}</h2>
        <button class="save-btn" @click="saveBudgets">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
          {{ t('saveBudgets') }}
        </button>
      </div>

      <p class="hint">{{ t('budgetAdvice') }}</p>

      <transition name="saved-fade">
        <p v-if="saved" class="saved">✓ {{ t('budgetsSaved') }}</p>
      </transition>

      <div v-if="loading" class="loading-state">
        <span>Chargement des dépenses…</span>
      </div>

      <div v-else-if="budgetRows.length" class="budget-list">
        <article v-for="item in budgetRows" :key="item.id" class="budget-item">
          <div class="row-top">
            <div class="cat-info">
              <h3>{{ item.name }}</h3>
              <p class="spent-label">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                {{ t('spent') }}: <strong>{{ currency(item.spent) }}</strong>
              </p>
            </div>
            <div class="limit-input">
              <label :for="`budget-${item.id}`">{{ t('budgetLimit') }}</label>
              <input :id="`budget-${item.id}`" v-model.number="limits[item.id]" type="number" min="0" step="0.01" :placeholder="'0'" />
            </div>
          </div>

          <div class="progress-track">
            <div
              class="progress-fill"
              :style="{ width: `${item.progress}%` }"
              :class="{ danger: item.remaining < 0, warning: item.progress > 75 && item.remaining >= 0 }"
            ></div>
          </div>

          <div class="row-bottom">
            <p class="remaining" :class="{ danger: item.remaining < 0 }">
              <span v-if="item.limit === 0" class="no-limit">Aucun budget défini</span>
              <span v-else-if="item.remaining < 0">⚠ {{ t('overBudget') }}: {{ currency(Math.abs(item.remaining)) }}</span>
              <span v-else>{{ t('remaining') }}: {{ currency(item.remaining) }}</span>
            </p>
            <span v-if="item.limit > 0" class="progress-pct">{{ Math.round(item.progress) }}%</span>
          </div>
        </article>
      </div>

      <p v-else class="empty">{{ t('noData') }}</p>
    </div>
  </div>
</template>

<style scoped>
.budgets-view { display: flex; flex-direction: column; gap: 20px; }
.subtitle { color: #6b7280; margin-top: 4px; }

/* ── Month Picker ── */
.month-picker-card {
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 14px;
  padding: 14px 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
}

.picker-label {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 0.9rem;
  color: #6b7280;
}

.picker-label svg { color: #9ca3af; }
.picker-label strong { color: #111827; font-size: 1rem; }

.picker-controls {
  display: flex;
  gap: 10px;
}

.picker-select {
  font-weight: 500;
  min-width: 120px;
}

/* ── Summary Strip ── */
.summary-strip {
  background: #f8f9fb;
  border-radius: 14px;
  padding: 16px 24px;
  display: flex;
  align-items: center;
  gap: 0;
  color: #111827;
  border: 1px solid #e5e7eb;
}

.summary-item {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 4px;
}

.summary-label {
  font-size: 0.75rem;
  color: #6b7280;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.summary-value {
  font-size: 1.1rem;
  font-weight: 600;
  color: #111827;
}

.summary-value.spent { color: #f59e0b; }
.summary-value.safe { color: #10b981; }
.summary-value.over { color: #ef4444; }

.summary-divider {
  width: 1px;
  height: 36px;
  background: #e5e7eb;
}

/* ── Card ── */
.card { background: white; border-radius: 16px; border: 1px solid #f3f4f6; padding: 24px; }

.card-header { display: flex; justify-content: space-between; align-items: center; gap: 12px; }
.card-header h2 { font-size: 1.1rem; font-weight: 600; color: #111827; }

.save-btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 10px 18px;
  background: #111827;
  color: white;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  font-size: 0.875rem;
  font-weight: 500;
  transition: all 0.2s;
}

.save-btn:hover {
  background: #1f2937;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.hint { color: #9ca3af; margin: 14px 0 4px; font-size: 0.85rem; }

.saved {
  color: #16a34a;
  font-weight: 600;
  margin-bottom: 12px;
  font-size: 0.9rem;
}

.saved-fade-enter-active, .saved-fade-leave-active { transition: all 0.3s ease; }
.saved-fade-enter-from, .saved-fade-leave-to { opacity: 0; transform: translateY(-4px); }

.loading-state {
  text-align: center;
  padding: 32px;
  color: #9ca3af;
  font-size: 0.9rem;
}

/* ── Budget List ── */
.budget-list { display: flex; flex-direction: column; gap: 14px; margin-top: 16px; }

.budget-item {
  border: 1.5px solid #f3f4f6;
  border-radius: 12px;
  padding: 16px 18px;
  transition: border-color 0.2s;
}

.budget-item:hover { border-color: #e5e7eb; }

.row-top {
  display: flex;
  justify-content: space-between;
  gap: 12px;
  margin-bottom: 14px;
  flex-wrap: wrap;
  align-items: flex-start;
}

.cat-info h3 { font-size: 0.95rem; color: #111827; margin-bottom: 5px; font-weight: 600; }

.spent-label {
  display: flex;
  align-items: center;
  gap: 5px;
  color: #6b7280;
  font-size: 0.85rem;
}

.spent-label strong { color: #374151; }

.limit-input {
  display: flex;
  flex-direction: column;
  gap: 5px;
  min-width: 160px;
}

.limit-input label { font-size: 0.78rem; color: #9ca3af; font-weight: 500; }

.limit-input input {
  border: 1.5px solid #e5e7eb;
  border-radius: 9px;
  padding: 9px 12px;
  font-size: 0.9rem;
  color: #111827;
  outline: none;
  transition: all 0.2s;
  background: #f9fafb;
  width: 100%;
}

.limit-input input:focus {
  border-color: #c9a84c;
  background: #fffbf0;
  box-shadow: 0 0 0 3px rgba(201,168,76,0.1);
}

/* ── Progress ── */
.progress-track {
  width: 100%;
  height: 8px;
  border-radius: 999px;
  background: #f3f4f6;
  overflow: hidden;
}

.progress-fill {
  height: 100%;
  border-radius: 999px;
  background: #10b981;
  transition: width 0.4s ease;
}

.progress-fill.warning { background: #f59e0b; }
.progress-fill.danger { background: #ef4444; }

.row-bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 8px;
}

.remaining { font-size: 0.85rem; color: #6b7280; }
.remaining.danger { color: #dc2626; font-weight: 600; }
.no-limit { color: #d1d5db; font-style: italic; }

.progress-pct {
  font-size: 0.78rem;
  color: #9ca3af;
  font-weight: 500;
}

.empty { color: #6b7280; text-align: center; padding: 32px 0; }
</style>