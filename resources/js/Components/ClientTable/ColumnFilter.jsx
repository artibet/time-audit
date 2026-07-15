import React from 'react'
import { TextInput } from './TextInput'
import { myDebounce } from '../../utils'
import { IntegerInput } from './IntegerInput'
import { SelectInput } from './SelectInput'
import { AutocompleteInput } from './AutocompleteInput'
import { ClientTableContext } from './ClientTable'

const ColumnFilter = ({ header }) => {

  // ---------------------------------------------------------------------------------------
  // Context data
  // ---------------------------------------------------------------------------------------
  const { table } = React.useContext(ClientTableContext)
  const columnFilters = table.getState().columnFilters

  const filterValue = api.getColumnFilter(column)

  // type == text
  if (column.filterType === 'text') {
    return (
      <TextInput
        activeColor={props.filterActiveColor}
        inactiveColor={props.filterInactiveColor}
        initialValue={filterValue}
        onChange={myDebounce((value) => api.handleColumnFilterChange(column, value), 300)}
        placeholder={column.filterPlaceholder}
      />
    )
  }

  // type == integer
  if (column.filterType === 'integer') {
    return (
      <IntegerInput
        activeColor={props.filterActiveColor}
        inactiveColor={props.filterInactiveColor}
        initialValue={filterValue}
        mask={column.filterMask}
        onChange={myDebounce((value) => api.handleColumnFilterChange(column, value), 300)}
        placeholder={column.filterPlaceholder}
      />
    )
  }

  // type == autocomplete
  if (column.filterType === 'autocomplete') {
    return (
      <AutocompleteInput
        activeColor={props.filterActiveColor}
        inactiveColor={props.filterInactiveColor}
        value={filterValue}
        valueKey={column.filterValueKey}
        labelKey={column.filterLabelKey}
        onChange={(value) => api.handleColumnFilterChange(column, value)}
        placeholder={column.filterPlaceholder}
        options={column.filterOptions}
      />
    )
  }

  // type == select
  if (column.filterType === 'select') {
    return (
      <SelectInput
        activeColor={props.filterActiveColor}
        inactiveColor={props.filterInactiveColor}
        value={filterValue}
        onChange={(value) => api.handleColumnFilterChange(column, value)}
        placeholder={column.filterPlaceholder}
        options={column.filterOptions}
      />
    )
  }

  // Not supported
  return null

}

export default ColumnFilter