import React from 'react'
import { ClientTableContext } from './ClientTable'
import { flexRender } from '@tanstack/react-table'
import { Box, TableCell, TableHead, TableRow } from '@mui/material'
import { TiArrowSortedDown, TiArrowSortedUp, TiArrowUnsorted } from 'react-icons/ti'

export const Head = () => {

  // ---------------------------------------------------------------------------------------
  // State
  // ---------------------------------------------------------------------------------------
  const { props, table } = React.useContext(ClientTableContext)

  // ---------------------------------------------------------------------------------------
  // Get sorting indicators
  // ---------------------------------------------------------------------------------------
  const createSortingHandlers = (header) => {
    const isSorted = header.column.getIsSorted()
    if (!isSorted) return <TiArrowUnsorted color='#cccccc' size={20} />
    else if (isSorted === 'asc') return <TiArrowSortedUp color='#7676daff' size={20} />
    else return <TiArrowSortedDown color='#7676daff' size={20} />
  }

  // ---------------------------------------------------------------------------------------
  // Get justification from meta 
  // ---------------------------------------------------------------------------------------
  const getJustification = header => {
    if (header.column.columnDef.meta?.align === 'right') return 'end'
    else if (header.column.columnDef.meta?.align == 'center') return 'middle'
    else return 'start'
  }

  // ---------------------------------------------------------------------------------------
  // Returns true if column filtering is enabled and there is at least on column with 
  // column filter enabled
  // ---------------------------------------------------------------------------------------
  const hasColumnFilters = () => {
    if (!table.options.enableColumnFilters) return false

    // Check if at least one column has column filter
    return table.getHeaderGroups().some(headerGroup =>
      headerGroup.headers.some(header => header.column.getCanFilter())
    )
  }

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (
    <TableHead>
      <>
        {
          table.getHeaderGroups().map(headerGroup => {
            return (
              <TableRow key={headerGroup.id}>
                {
                  headerGroup.headers.map(header => (
                    <TableCell key={header.id} component='th' scope='col' colSpan={header.colSpan} onClick={header.column.getToggleSortingHandler()} style={{ cursor: header.column.getCanSort() ? 'pointer' : 'default' }}>
                      <Box sx={{ display: 'flex', flexDirection: 'row', gap: 0.5, justifyContent: header.column.columnDef.meta?.align, alignItems: 'middle' }}>
                        <Box sx={{ fontWeight: 'bold' }}>
                          {flexRender(header.column.columnDef.header, header.getContext())}
                        </Box>
                        <Box>
                          {createSortingHandlers(header)}
                        </Box>
                      </Box>

                    </TableCell>
                  ))
                }
              </TableRow>
            )
          })
        }

        {/* Add Extra row for column filter fields */}
        {
          hasColumnFilters() &&
          table.getHeaderGroups().map(headerGroup => {
            return (
              <TableRow key={headerGroup.id}>
                {
                  headerGroup.headers.map(header => (
                    <TableCell key={header.id} >

                    </TableCell>
                  ))
                }
              </TableRow>
            )
          })
        }
      </>
    </TableHead >
  )
}
