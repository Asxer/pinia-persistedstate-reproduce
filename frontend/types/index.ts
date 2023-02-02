export * from './state'

export declare interface Entity {
  id?: number

  created_at?: string | Date
  updated_at?: string | Date
}

export interface City extends Entity {
  name: string
}

export interface Country extends Entity {
  name: string
}
