import React from 'react'
import { router, usePage } from '@inertiajs/react';
import { Dashboard, DateRange, Domain, FactCheck, LocationOn, MyLocation, PeopleAlt, PestControl, SettingsSuggest, Shower } from '@mui/icons-material';

export const getSidebarMenuItems = () => {


  const { url } = usePage()
  const { auth } = usePage().props

  // ---------------------------------------------------------------------------------------
  // Διαχείριση - section
  // ---------------------------------------------------------------------------------------
  const administrationSection = {
    label: "Διαχείριση",
    section: true,
    hidden: () => !auth.user.is_superadmin
  }

  // ---------------------------------------------------------------------------------------
  // Χρήστες & Ρόλοι
  // ---------------------------------------------------------------------------------------
  const usersMenu = {
    label: 'Χρήστες & Ρόλοι',
    icon: <PeopleAlt />,
    onClick: () => router.get('/users'),
    active: () => url.startsWith("/users"),
    hidden: () => !auth.user.is_superadmin,
  }

  // ---------------------------------------------------------------------------------------
  // Παράμετροι
  // ---------------------------------------------------------------------------------------
  const paramsMenu = {
    label: 'Παράμετροι',
    icon: <SettingsSuggest />,
    onClick: () => router.get('/params'),
    active: () => url.startsWith("/params"),
    hidden: () => !auth.user.has_admin_rights,
  }



  // ---------------------------------------------------------------------------------------
  // Return array of menus
  // ---------------------------------------------------------------------------------------
  return [

    administrationSection,
    usersMenu,
    paramsMenu,
  ]

}

