import React from 'react'
import { ClientTableContext } from './ClientTable'
import { TextInput } from './TextInput'

export const GlobalFilter = () => {

  // ---------------------------------------------------------------------------------------
  // State
  // ---------------------------------------------------------------------------------------
  const { table, state, props } = React.useContext(ClientTableContext)

  // ---------------------------------------------------------------------------------------
  // handle global filter change
  // ---------------------------------------------------------------------------------------
  const handleChange = (value) => {
    state.setGlobalFilter(value)
    table.setGlobalFilter(value)
  }

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  if (!table.options.enableGlobalFilter) return null

  return (
    <TextInput
      size='small'
      value={state.globalFilter}
      initialValue={table.getState().globalFilter}
      onChange={handleChange}
      placeholder={props.globalFilterPlaceholder}
    />
  )
}
