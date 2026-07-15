import { ClientTable } from '@/Components/ClientTable/ClientTable'
import { ExcelIcon } from '@/Components/ExcelIcon'
import { formatFloat } from '@artibet/react-mui-components/utils'
import { Box, Button, Card, CardContent, Tooltip } from '@mui/material'
import React, { useMemo } from 'react'

export const OvertimesTable = ({ data, filters }) => {

  // ---------------------------------------------------------------------------------------
  // Table columns
  // ---------------------------------------------------------------------------------------
  const columns = useMemo(() => [
    {
      accessorKey: 'am',
      header: 'Α.Μ.',
    },
    {
      accessorKey: 'lastname',
      header: 'Επώνυμο',
    },
    {
      accessorKey: 'firstname',
      header: 'Όνομα',
    },
    {
      accessorKey: 'total_raw_hours',
      header: 'Σύνολο Υπερωριών',
      cell: value => (
        <Box>{formatFloat(value.getValue(), 2)} ώρ.</Box>
      ),
      meta: {
        align: 'right'
      }
    },
    {
      accessorKey: 'total_capped_hours',
      header: 'Δικαιούμενες Υπερωρίες',
      cell: value => (
        <Box>{formatFloat(value.getValue(), 2)} ώρ.</Box>
      ),
      meta: {
        align: 'right'
      }
    },
  ], [data])

  // ---------------------------------------------------------------------------------------
  // Export to excel action
  // ---------------------------------------------------------------------------------------  
  const exportExcel = () => {

    const handleExport = () => {
      // 1. Build the query parameters dynamically
      const params = new URLSearchParams({
        year: filters.year || '',
        month_from: filters.month_from || '',
        month_to: filters.month_to || '',
      });

      // 2. Open the export URL with the query string appended
      window.open(`/reports/period-overtimes/export?${params.toString()}`);
    };

    return (
      <Tooltip placement='top' title='Εξαγωγή σε Excel'>
        <Button
          variant='contained'
          color="success"
          onClick={handleExport}
          disabled={!filters.year || !filters.month_from || !filters.month_to}
        >
          <ExcelIcon />
        </Button>
      </Tooltip>
    )
  }

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (
    <Card variant="outlined">
      <CardContent>
        <ClientTable
          columns={columns}
          data={data}
          title='Πίνακας Δικαιούχων Υπαλλήλων'
          tableSize='medium'
          enableGlobalFilter={true}
          globalFilterPlaceholder='Αναζήτηση'
          enableColumnFilters={false}
          enableCreateRow={false}
          globalActions={[exportExcel()]}
        />
      </CardContent>
    </Card>
  )
}
