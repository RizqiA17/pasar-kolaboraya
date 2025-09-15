# Pilar II - Ekosistem Scoring System

## Overview
The Ekosistem scoring system calculates the quality of an ecosystem based on 6 key metrics. The final score is the average of all 6 individual scores.

## Metrics

### 1. Membership Activation Rate
- **Data Source**: `ecosystem_users` table with `status = 'accepted'`
- **Formula**: `activation_rate = accepted / max_users`
- **Score**: `min(activation_rate, 1) * 100`
- **Description**: Measures how well the ecosystem has reached its membership capacity

### 2. Ecosystem Acceptance Rate
- **Data Source**: `ecosystem_users` table with `status = 'accepted'` and `status = 'rejected'`
- **Formula**: `acceptance_rate = accepted / (accepted + rejected)`
- **Score**: `acceptance_rate * 100`
- **Description**: Measures the quality of membership applications (higher acceptance rate indicates better targeting)

### 3. Ecosystem Contribution Completion Rate
- **Data Source**: `ecosystem_contributions` table
- **Formula**: `completion_rate = completed / total`
- **Score**: `completion_rate * 100`
- **Description**: Measures how well the ecosystem follows through on contributions

### 4. Ecosystem Contribution Diversity
- **Data Source**: `ecosystem_contributions` joined with `contributions` table
- **Formula**: 
  - Calculate HHI (Herfindahl-Hirschman Index): `HHI = Σ(sᵢ²)` where sᵢ is the proportion of contribution type i
  - Diversity Score: `(1 - HHI) / (1 - 1/K) * 100` where K is the number of unique contribution types
- **Description**: Measures the diversity of contribution types (higher diversity = better ecosystem health)

### 5. Role Fit (Kesesuaian Kebutuhan Skill)
- **Data Source**: `ecosystems.existing_roles` and `ecosystems.needed_roles` JSON arrays
- **Formula**: `coverage = count(existing_roles ∩ needed_roles) / count(needed_roles)`
- **Score**: `coverage * 100`
- **Description**: Measures how well the ecosystem's existing roles match its needed roles

### 6. Ecosystem Engagement in Collective Actions
- **Data Source**: `collective_action_ecosystem_invitations` table
- **Formula**: `engagement_rate = accepted / invited`
- **Score**: `engagement_rate * 100`
- **Description**: Measures how actively the ecosystem participates in collective actions

## Final Score
The final Ekosistem score is calculated as the average of all 6 individual scores:
```
Ekosistem_score = (activation_score + acceptance_score + completion_score + diversity_score + role_fit_score + engagement_score) / 6
```

## Usage

### In Ecosystem Model
```php
$ecosystem = Ecosystem::find(1);
$score = $ecosystem->calculateEkosistemScore();

// Access individual scores
echo $score['activation_score'];     // 0-100
echo $score['acceptance_score'];     // 0-100
echo $score['completion_score'];     // 0-100
echo $score['diversity_score'];      // 0-100
echo $score['role_fit_score'];       // 0-100
echo $score['engagement_score'];     // 0-100
echo $score['ekosistem_score'];      // 0-100 (final score)

// Access detailed data
$details = $score['details'];
echo $details['accepted_members'];
echo $details['max_users'];
// ... and more
```

### In PasarKolaboraya Model
```php
$pasarKolaboraya = PasarKolaboraya::find(1);
$healthScore = $pasarKolaboraya->calculateEcosystemHealth(); // Uses new Ekosistem scoring
```

## Database Tables Used
- `ecosystems` - Main ecosystem data
- `ecosystem_users` - User membership status
- `ecosystem_contributions` - Contribution records
- `contributions` - Master contribution types
- `collective_action_ecosystem_invitations` - Collective action invitations

## Notes
- All scores are rounded to 1 decimal place
- Division by zero is handled gracefully (returns 0)
- The system is designed to be robust and handle missing data
- Scores range from 0 to 100 for easy interpretation
