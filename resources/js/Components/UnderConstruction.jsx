import React from 'react';
import { Box, Typography, Container } from '@mui/material';
import { styled } from '@mui/material/styles';
import { Construction } from '@mui/icons-material';

// 1. Styled Component for Visual Flair
const StyledBox = styled(Box)(({ theme }) => ({
  display: 'flex',
  flexDirection: 'column',
  alignItems: 'center',
  justifyContent: 'center',
  minHeight: '60vh', // Ensures it takes up a good amount of vertical space
  textAlign: 'center',
  padding: theme.spacing(4),
  backgroundColor: theme.palette.background.default,
  borderRadius: theme.shape.borderRadius,
}));

/**
 * A Material-UI component to display an "Under Construction" message.
 * @param {object} props - Component props.
 * @param {string} [props.title="Page Under Construction"] - The main title text.
 * @param {string} [props.message="We are working hard to bring you this page. Please check back soon!"] - The detailed message.
 */
export const UnderConstruction = ({
  title = "Page Under Construction",
  message = "We are working hard to bring you this page. Please check back soon!",
}) => {
  return (
    <Container maxWidth="sm">
      <StyledBox>
        {/* 2. The Icon */}
        <Construction
          color="warning" // Use a warning color for the construction theme
          sx={{ fontSize: 80, mb: 2 }} // Large size and margin bottom
        />

        {/* 3. The Title */}
        <Typography variant="h4" component="h1" gutterBottom>
          **{title}**
        </Typography>

        {/* 4. The Message */}
        <Typography variant="body1" color="text.secondary">
          {message}
        </Typography>

        {/* Optional: Add a subtle loading spinner for motion */}
        <Box sx={{ mt: 3, opacity: 0.6 }}>
          {/* You could add a CircularProgress here if desired */}
        </Box>
      </StyledBox>
    </Container>
  );
};

