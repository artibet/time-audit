import React from 'react'
import { ClientTableContext } from './ClientTable'
import { TablePagination } from '@mui/material'

export const Paginator = () => {

  // ---------------------------------------------------------------------------------------
  // State and context
  // ---------------------------------------------------------------------------------------
  const { props, table } = React.useContext(ClientTableContext)

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (
    <TablePagination
      sx={{ marginTop: 1, overflow: 'hidden' }}
      component="div"
      showFirstButton
      showLastButton
      count={table.getFilteredRowModel().rows.length}
      page={table.getState().pagination.pageIndex}
      rowsPerPage={table.getState().pagination.pageSize}
      onPageChange={(_, page) => table.setPageIndex(page)}
      onRowsPerPageChange={e => table.setPageSize(Number(e.target.value))}
      labelDisplayedRows={props => `${props.from} έως ${props.to} από ${props.count}`}
      labelRowsPerPage='Εγγραφές ανά σελίδα'
    />
  )
}
