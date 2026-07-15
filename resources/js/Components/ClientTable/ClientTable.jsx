import React from 'react'
import { getCoreRowModel, getFilteredRowModel, getPaginationRowModel, getSortedRowModel, useReactTable } from '@tanstack/react-table'
import { Paginator } from './Paginator'
import { Box, Table, TableContainer, } from '@mui/material'
import { Head } from './Head'
import { Body } from './Body'
import { Title } from './Title'
import { GlobalFilter } from './GlobalFilter'
import CreateButton from './CreateButton'
import { Footer } from './Footer'
import { GlobalActions } from './GlobalActions'

const fallbackData = []

export const ClientTableContext = React.createContext()

// ---------------------------------------------------------------------------------------
// Default pagination
// ---------------------------------------------------------------------------------------
const defaultPageIndex = 0
const defaultPageSize = 10

export const ClientTable = ({
  columns = [],
  data = [],
  title = '',
  titleStyle = {},
  rowStyle = null,
  cellStyle = null,
  tableSize = 'medium',
  enableGlobalFilter = false,
  enableColumnFilters = false,
  globalFilterPlaceholder = 'Καθολική Αναζήτηση',
  enableCreateRow = false,
  createButtonVariant = 'contained',
  createButtonTooltip = 'Νέα Εγγραφή',
  onCreateRow = null,
  rowsClickable = false,
  onRowClick = null,
  globalActions = [],
  rowActions = [],
  keepState = true,
  stateKey = null,
  filterActiveColor = '#D4F7F4',
  filterInactiveColor = 'white',
  defaultSorting = [],
  initialPageSize = defaultPageSize
}) => {

  // ---------------------------------------------------------------------------------------
  // session keys
  // ---------------------------------------------------------------------------------------
  const pageIndexKey = React.useMemo(() => {
    if (!keepState || !stateKey) return false // not keeping state
    return `${stateKey}.pageIndex`
  }, [])

  const pageSizeKey = React.useMemo(() => {
    if (!keepState || !stateKey) return false // not keeping state
    return `${stateKey}.pageSize`
  }, [])

  const sortingKey = React.useMemo(() => {
    if (!keepState || !stateKey) return false // not keeping state
    return `${stateKey}.sorting`
  }, [])

  const globalFilterKey = React.useMemo(() => {
    if (!keepState || !stateKey) return false // not keeping state
    return `${stateKey}.globalFilter`
  }, [])

  const columnFiltersKey = React.useMemo(() => {
    if (!keepState || !stateKey) return false // not keeping state
    return `${stateKey}.columnFilters`
  }, [])


  // ---------------------------------------------------------------------------------------
  // State and hooks
  // ---------------------------------------------------------------------------------------
  const [globalFilter, setGlobalFilter] = React.useState('')
  const [columnFilters, setColumnFilters] = React.useState([])

  const table = useReactTable({
    columns,
    data: data ?? fallbackData,
    getCoreRowModel: getCoreRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    globalFilterFn: 'includesString',
    enableGlobalFilter: enableGlobalFilter,
    enableColumnFilters: enableColumnFilters,
    globalFilter: globalFilter,
    columnFilters: columnFilters,
    sorting: defaultSorting,    // An array of objects: {id: 'name', desc: true|false}
    initialState: {
      pagination: {
        defaultPageIndex,
        defaultPageSize
      },
    },
  })

  // ---------------------------------------------------------------------------------------
  // Context
  // ---------------------------------------------------------------------------------------
  const context = {
    props: {
      columns,
      data,
      title,
      titleStyle,
      rowStyle,
      cellStyle,
      tableSize,
      enableGlobalFilter,
      enableColumnFilters,
      globalFilterPlaceholder,
      enableCreateRow,
      createButtonVariant,
      createButtonTooltip,
      onCreateRow,
      rowsClickable,
      onRowClick,
      globalActions,
      rowActions,
      keepState,
      stateKey,
      filterActiveColor,
      filterInactiveColor,
      defaultSorting,
      initialPageSize
    },
    state: {
      globalFilter,
      setGlobalFilter,
      columnFilters,
      setColumnFilters,
    },
    table: table
  }

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (
    <ClientTableContext.Provider value={context}>

      {/* Title, globalFilter, createButton, globalActions */}
      <Box sx={{
        display: 'flex',
        flexDirection: { xs: 'column', md: 'row' },
        justifyContent: { xs: 'top', md: 'space-between' },
        alignItems: { xs: 'left', md: 'center' },
        marginBottom: 1
      }}>
        <Title />
        <Box sx={{
          display: 'flex', gap: 2,
          justifyContent: 'end',
          alignItems: 'center',
          marginTop: { xs: 2, md: 0 }
        }}>
          <GlobalFilter />
          <CreateButton />
          <GlobalActions />
        </Box>
      </Box>

      {/* The table */}
      <TableContainer>
        <Table size={tableSize}>
          <Head />
          <Body />
          <Footer />
        </Table>
      </TableContainer>
      <Paginator />

    </ClientTableContext.Provider>
  )
}
