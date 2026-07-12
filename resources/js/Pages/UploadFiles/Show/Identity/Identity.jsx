import { DateTimeProperty, FileProperty, PropertyGroup, StringProperty } from '@artibet/react-mui-components/properties'
import { usePage } from '@inertiajs/react'
import { UploadFile } from '@mui/icons-material'
import React from 'react'

export const Identity = () => {

  // ---------------------------------------------------------------------------------------
  // State and context
  // ---------------------------------------------------------------------------------------
  const { upload_file } = usePage().props

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (
    <PropertyGroup sx={{ mt: 3 }} >

      {/* descr */}
      <StringProperty
        label='Περιγραφή Αρχείου'
        value={upload_file.descr}
        editable={true}
        fieldName='descr'
        required
        modalTitle='Περιγραφή Αρχείου'
        updateUrl={upload_file.url.update}
      />

      {/* starts_at */}
      <DateTimeProperty
        label='Πρώτη Καταχώρηση'
        value={upload_file.starts_at}
        editable={false}
        required={false}
        placeholder='-----'
      />

      {/* ends_at */}
      <DateTimeProperty
        label='Τελευταία Καταχώρηση'
        value={upload_file.ends_at}
        editable={false}
        required={false}
        placeholder='-----'
      />

      {/* employees_count */}
      <StringProperty
        label='Πλήθος Εργαζομένων'
        value={upload_file.employees_count}
        editable={false}
        required={false}
        placeholder='-----'
      />

      {/* media file */}
      <FileProperty
        label='Αρχείο'
        exists={Boolean(upload_file.media)}
        fileName={`${upload_file.media?.file_name} (${upload_file.media?.human_readable_size})`}
        editable={false}
        required={true}
        downloadUrl={upload_file.media?.url?.download}
        hasDivider={false}
      />

    </PropertyGroup>
  )
}
