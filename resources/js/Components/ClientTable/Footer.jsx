import { TableCell, TableFooter, TableRow } from '@mui/material'
import React from 'react'
import { ClientTableContext } from './ClientTable'
import { flexRender } from '@tanstack/react-table'

export const Footer = () => {

  // ---------------------------------------------------------------------------------------
  // State
  // ---------------------------------------------------------------------------------------
  const { table } = React.useContext(ClientTableContext)

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (
    <TableFooter>
      {
        table.getFooterGroups().map(footerGroup => (
          <TableRow key={footerGroup.id}>
            {
              footerGroup.headers.map(header => (
                <TableCell key={header.id} sx={{ fontWeight: 'bold', fontSize: 14, textAlign: header.column.columnDef.meta?.align || '' }}>
                  {flexRender(header.column.columnDef.footer, header.getContext())}
                </TableCell>
              ))
            }
          </TableRow>
        ))
      }
    </TableFooter>
  )
}
