<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UniformModel;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // Search uniforms
        $uniforms = UniformModel::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orWhere('size', 'like', "%{$query}%")
            ->get();
        
        // Search about page content (hardcoded matches)
        $aboutMatches = $this->searchAboutContent($query);
        $missionMatches = $this->searchMissionContent($query);
        $teamMatches = $this->searchTeamContent($query);
        
        return view('search.results', [
            'query' => $query,
            'uniforms' => $uniforms,
            'aboutMatches' => $aboutMatches,
            'missionMatches' => $missionMatches,
            'teamMatches' => $teamMatches,
        ]);
    }
    
    protected function searchAboutContent($query)
    {
        $aboutContent = [
            "Welcome to Cooperatiba, your trusted cooperative dedicated to delivering smooth and fast transactions for students.",
            "Established in 2025, we are driven by a mission to provide high-quality uniforms.",
            "Our team is committed to ensuring efficient operations and delivering exceptional service.",
            "What sets Cooperatiba apart is our focus on speed, efficiency, and quality."
        ];
        
        return $this->searchInArray($aboutContent, $query);
    }
    
    protected function searchMissionContent($query)
    {
        $missionContent = [
            "To provide high-quality academic essentials at student-friendly prices through cooperative economics",
            "To simplify the uniform-buying process, reducing the hassle of physical shopping",
            "We believe that 'by students, for students' is more than just a motto"
        ];
        
        return $this->searchInArray($missionContent, $query);
    }
    
    protected function searchTeamContent($query)
    {
        $teamMembers = [
            ["name" => "Christopher Hilairon", "role" => "Programmer", "bio" => "Designs and develops system functionalities"],
            ["name" => "Franz Abad", "role" => "Technical Writer", "bio" => "Documents technical processes"],
            ["name" => "Kurt Virina", "role" => "Project Manager", "bio" => "Leads the planning and execution"],
            ["name" => "Randel Hernandez", "role" => "System Analyst", "bio" => "Analyzes system requirements"],
            ["name" => "Cholo Belen", "role" => "Tester", "bio" => "Conducts rigorous testing"],
            ["name" => "Lance Dimaliabot", "role" => "Tester", "bio" => "Validates product functionality"]
        ];
        
        return collect($teamMembers)->filter(function($member) use ($query) {
            return stripos($member['name'], $query) !== false || 
                   stripos($member['role'], $query) !== false || 
                   stripos($member['bio'], $query) !== false;
        })->values();
    }
    
    protected function searchInArray(array $content, $query)
    {
        return collect($content)->filter(function($text) use ($query) {
            return stripos($text, $query) !== false;
        })->values();
    }
}