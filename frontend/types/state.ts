import { City, Country } from '~/types/index'
import { Paginated, SearchFilters } from '~/types/search'

export interface RootState {
  title: string | null,
  pendingRequestsCount: number
}

export interface AuthState {
  token: string | null
}

export interface SimpleEntityState<T, R> {
  items: Paginated<T>
  item: T
  filters: R
}

export interface CitiesState extends SimpleEntityState<City, SearchFilters> {}
export interface CountriesState extends SimpleEntityState<Country, SearchFilters> {}