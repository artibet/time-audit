import React from 'react'
import { AutocompleteMultiProperty, EmailProperty, PropertyGroup, StringProperty, ToggleProperty } from '@artibet/react-mui-components/properties'
import { usePage } from '@inertiajs/react'
import { StatusChip } from '@artibet/react-mui-components'

export const Identity = () => {

  // ---------------------------------------------------------------------------------------
  // State and context
  // ---------------------------------------------------------------------------------------
  const { user, roles } = usePage().props

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (

    <PropertyGroup sx={{ mt: 3 }} title='ΣΤΟΙΧΕΙΑ ΧΡΗΣΤΗ'>

      {/* Επώνυμο */}
      <StringProperty
        label='Επωνυμία'
        value={user.name}
        fieldName='name'
        editable={user.policy.update}
        required
        modalTitle='Επεξεργασία Επωνυμίας'
        updateUrl={user.url.update}
      />

      {/* Email */}
      <EmailProperty
        label='Ε-mail'
        value={user.email}
        fieldName='email'
        editable={user.policy.update}
        required
        modalTitle='Επεξεργασία Email'
        updateUrl={user.url.update}
      />

      {/* roles */}
      <AutocompleteMultiProperty
        label='Ρόλοι'
        value={user.roles}
        fieldName='roles'
        options={roles}
        editable={user.policy.update_roles}
        required
        modalTitle='Επιλογή Ρόλων'
        updateUrl={user.url.update}
      />

      {/* is_active */}
      <ToggleProperty
        label='Κατάσταση'
        value={user.is_active}
        render={(
          <StatusChip label={user.is_active_label} isActive={user.is_active} inactiveBgColor='error.main' inactiveColor='#ffffff' inactiveVariant='filled' />
        )}
        fieldName='is_active'
        editable={user.policy.update_status}
        activationLabel='Ενεργοποίηση Χρήστη'
        deactivationLabel='Απενεργοποίηση Χρήστη'
        activationMessage='Να ενεργοποιηθεί ο επιλεγμενος Χρήστης-Μέλος;'
        deactivationMessage='Να απενεργοποιηθεί ο επιλεγμενος Χρήστης-Μέλος;'
        updateUrl={user.url.update}
      />
    </PropertyGroup>

  )
}
