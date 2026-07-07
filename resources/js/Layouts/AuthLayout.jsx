import React from 'react'
import { Head, router, usePage, } from '@inertiajs/react'
import { getSidebarMenuItems } from './Sidebar'
import { SidebarLogo } from './SidebarLogo'
import { SidebarLayout } from "@artibet/react-sidebar-layout"
import { Footer } from './Footer';
import { theme } from './theme';
import { Box } from '@mui/material'
import { AccountCircle, Logout } from '@mui/icons-material'

export const AuthLayout = ({ children, title }) => {

  const { auth, flash } = usePage().props

  // ---------------------------------------------------------------------------------------
  // Topbar dropdown menu 
  // ---------------------------------------------------------------------------------------
  const topbarMenuItems = [
    {
      label: (
        <Box sx={{ display: 'flex', flexDirection: 'column', alignItems: 'center', marginLeft: 0 }}>
          <Box >{auth.user?.name}</Box>
        </Box>
      ),
      icon: <AccountCircle sx={{ marginRight: 0, color: '#7DA0FA' }} />,
      tooltip: "Μενού Χρήστη",
      hidden: () => false,
      group: [
        {
          label: "Αποσύνδεση",
          icon: <Logout />,
          onClick: () => router.post("/logout"),
        },
      ],
    },
  ]

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (
    <>
      <Head title={title} />
      <SidebarLayout
        theme={theme}
        sidebarMenuItems={getSidebarMenuItems()}
        topbarMenuItems={topbarMenuItems}
        sidebarLogo={<SidebarLogo />}
        // topbarLogo={<TopbarLogo />}
        footer={<Footer />}
      >
        {children}
      </SidebarLayout>
    </>
  )
}
