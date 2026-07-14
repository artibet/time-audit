import { DateTimeProperty, PropertyGroup, StringProperty, TimeProperty } from '@artibet/react-mui-components/properties'
import { usePage } from '@inertiajs/react'
import React from 'react'

export const Identity = () => {

  // ---------------------------------------------------------------------------------------
  // State and context
  // ---------------------------------------------------------------------------------------
  const { employee } = usePage().props

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (
    <PropertyGroup sx={{ mt: 3 }} >

      {/* am */}
      <StringProperty
        label='Αριθμός Μητρώου'
        value={employee.am}
        editable={true}
        fieldName='am'
        required
        modalTitle='Αριθμός Μητρώου'
        updateUrl={employee.url.update}
      />

      {/* lastname */}
      <StringProperty
        label='Επώνυμο'
        value={employee.lastname}
        editable={true}
        fieldName='lastname'
        required
        modalTitle='Επώνυμο'
        updateUrl={employee.url.update}
      />

      {/* firstname */}
      <StringProperty
        label='Όνομα'
        value={employee.firstname}
        editable={true}
        fieldName='firstname'
        required
        modalTitle='Όνομα'
        updateUrl={employee.url.update}
      />

      {/* card_no */}
      <StringProperty
        label='Αριθμός Κάρτας'
        value={employee.card_no}
        editable={true}
        fieldName='card_no'
        required
        modalTitle='Αριθμός Κάρτας'
        updateUrl={employee.url.update}
      />

      {/* last_in */}
      <DateTimeProperty
        label='Τελευταία Είσοδος'
        value={employee.last_in}
        editable={false}
        required={false}
        placeholder='-----'
      />

      {/* last_out */}
      <DateTimeProperty
        label='Τελευταία Έξοδος'
        value={employee.last_out}
        editable={false}
        required={false}
        placeholder='-----'
      />

    </PropertyGroup>
  )
}
