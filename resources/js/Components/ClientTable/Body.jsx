import React from 'react'
import { ClientTableContext } from './ClientTable'
import { flexRender } from '@tanstack/react-table'
import { TableBody, TableCell, TableRow } from '@mui/material'

export const Body = () => {

  // ---------------------------------------------------------------------------------------
  // State
  // ---------------------------------------------------------------------------------------
  const { table, props } = React.useContext(ClientTableContext)

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (
    <TableBody>
      {table.getRowModel().rows.map(row => {
        const rstyle = props.rowStyle !== null ? props.rowStyle(row.original) : {}
        return (
          <TableRow key={row.id} sx={{ ...rstyle }}>
            {row.getVisibleCells().map(cell => (
              <TableCell key={cell.id} sx={{ textAlign: cell.column.columnDef.meta?.align || '' }}>
                {flexRender(
                  cell.column.columnDef.cell,
                  cell.getContext()
                )}
              </TableCell>
            ))}
          </TableRow>
        )
      })}
    </TableBody >
  )
}
